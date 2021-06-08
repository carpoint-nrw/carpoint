<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\DatabaseDump;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class DatabaseDumpController
 *
 * @Route("/dump")
 *
 * @package AdminBundle\Controller
 */
class DatabaseDumpController extends Controller
{
    /**
     * @var string
     */
    private $dumpPath;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var string
     */
    private $databaseName;

    /**
     * @var string
     */
    private $databaseUser;

    /**
     * @var string|null
     */
    private $databasePassword;

    /**
     * DatabaseDumpController constructor.
     *
     * @param string          $dumpPath
     * @param LoggerInterface $logger
     * @param string          $databaseName
     * @param string          $databaseUser
     * @param string|null     $databasePassword
     */
    public function __construct(
        string $dumpPath,
        LoggerInterface $logger,
        string $databaseName,
        string $databaseUser,
        $databasePassword
    ) {
        $this->dumpPath         = $dumpPath;
        $this->logger           = $logger;
        $this->databaseName     = $databaseName;
        $this->databaseUser     = $databaseUser;
        $this->databasePassword = $databasePassword;
    }

    /**
     * @Route("")
     * @Template
     *
     * @return array
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/ajax-data")
     *
     * @param Request $request A Request instance.
     *
     * @return JsonResponse
     */
    public function ajaxData(
        Request $request
    ): JsonResponse {
        $start = $request->query->get('start');
        $length = $request->query->get('length');
        $order = $request->query->get('order');
        $columns = $request->query->get('columns');
        $columnSort = $columns[$order[0]['column']]['name'];
        $sortType = $order[0]['dir'];

        $em = $this->getDoctrine()->getManager();
        [$count, $dumps] = $em->getRepository(DatabaseDump::class)
            ->getDumps($start, $length, $columnSort, $sortType);

        $data = [];
        foreach ($dumps as $dump) {
            $data[] = [
                'dumpId' => $dump->getId(),
                'date' => $dump->getDate()->format('Y-m-d H:i:s')
            ];
        }

        return JsonResponse::create([
            'data'            => $data,
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
        ]);
    }

    /**
     * @Route("/restore/{id}", requirements={"id"="\d+"}, defaults={ "id": "0" })
     *
     * @param string $id
     *
     * @return array|Response
     */
    public function restore(string $id)
    {
        try {
            $this->logger->info('restoreDump', ['message' => 'init']);

            $em = $this->getDoctrine()->getManager();
            $file = $em->getRepository(DatabaseDump::class)->find($id);
            if ($file === null) {
                throw new NotFoundHttpException('Database file not found');
            }

            if (file_exists($this->dumpPath . '/' . $file->getFileName())) {
                exec('mysql -u' . $this->databaseUser
//                    . ' -p' . $this->databasePassword
                    . ' ' . $this->databaseName
                    .' < '
                    . $this->dumpPath . '/' . $file->getFileName() . ' 2>&1', $output, $return_var
                );
                if ($return_var) {
                    foreach ($output as $message){
                        throw new \ErrorException($message);
                    }
                }
            } else {
                throw new \ErrorException('Mysql file not found');
            }

            $this->logger->info('restoreDump', ['message' => 'complete']);
        } catch (\Throwable $exception) {
            $this->logger->error('restoreDump', [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'message' => $exception->getMessage(),
            ]);
        }
        return $this->redirectToRoute('admin_databasedump_index');
    }
}