<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Car;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Class InvoiceController
 *
 * @Route("/invoices")
 *
 * @package AdminBundle\Controller
 */
class InvoiceController extends Controller
{
    /**
     * @var string
     */
    private $filesPath;

    /**
     * @var string
     */
    private $carInvoicePath;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * InvoiceController constructor.
     *
     * @param string          $filesPath
     * @param string          $carInvoicePath
     * @param LoggerInterface $logger
     */
    public function __construct(
        string          $filesPath,
        string          $carInvoicePath,
        LoggerInterface $logger
    ) {
        $this->filesPath      = $filesPath;
        $this->carInvoicePath = $carInvoicePath;
        $this->logger         = $logger;
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
     * @Route("/get-filter-data")
     *
     * @param Request $request A Request instance.
     *
     * @return JsonResponse
     */
    public function getFilterData(Request $request): JsonResponse
    {
        $em    = $this->getDoctrine()->getManager();
        $dates = $em->getRepository(Car::class)->getInvoiceFilterData();

        $data = [];
        foreach ($dates as $date) {
            $date  = new \DateTime($date[1]);
            $year  = $date->format('Y');
            $month = $date->format('F');

            $data[$year][] = $month;
        }

        $data = array_map(function ($elem) {
            $months = array_unique($elem);

            usort($months, function ($a, $b) {
                $monthA = date_parse($a);
                $monthB = date_parse($b);

                return $monthA['month'] - $monthB['month'];
            });

            return array_unique($months);
        }, $data);

        krsort($data);

        return JsonResponse::create($data);
    }

    /**
     * @Route("/download-files")
     *
     * @param Request $request A Request instance.
     *
     * @return mixed
     */
    public function downloadFiles(Request $request)
    {
        $year  = $request->query->get('year');
        $month = $request->query->get('month');

        if ($year === 'undefined' || $month === 'undefined') {
            return $this->redirect($request->headers->get('referer'));
        } else {
            $month      = date('m', strtotime($month));
            $searchDate = $year.'-'.$month;
            $em    = $this->getDoctrine()->getManager();
            $files = $em->getRepository(Car::class)->getInvoiceFilesByMonth($searchDate);
        }

        $tempFilesDir = $this->filesPath.'/temp/'.mt_rand().time();
        if (!mkdir($tempFilesDir)) {
            throw new \Exception();
        }

        foreach ($files as $file) {
            $fileName     = $file['invoiceFileName'];
            $filePath     = $this->carInvoicePath.'/'.$fileName;
            $fileCopyPath = $tempFilesDir.'/'.$fileName;
            if (file_exists($filePath)) {
                copy($filePath, $fileCopyPath);
            }
        }

        exec("cd $tempFilesDir; zip -r data.zip . 2>&1", $output, $return_var);
        if ($return_var) {
            $error = '';
            foreach ($output as $message) {
                $error = $error === '' ? $message : $error.'; '.$message;
            }
            $this->logger->critical($error);

            return $this->redirect($request->headers->get('referer'));
        }

        return $this->file(
            $tempFilesDir.'/data.zip',
            'data.zip',
            ResponseHeaderBag::DISPOSITION_ATTACHMENT
        );
    }

    /**
     * @Route("/ajax-data")
     *
     * @param Request $request A Request instance.
     *
     * @return JsonResponse
     */
    public function ajaxInvoice(
        Request $request
    ): JsonResponse {
        $start      = $request->request->get('start');
        $length     = $request->request->get('length');
        $order      = $request->request->get('order');
        $columns    = $request->request->get('columns');
        $columnSort = $columns[$order[0]['column']]['name'];
        $sortType   = $order[0]['dir'];
        $year       = $request->request->get('year');
        $month      = $request->request->get('month');
        $month      = date('m', strtotime($month));
        $searchDate = $year.'-'.$month;

        $em = $this->getDoctrine()->getManager();
        [$count, $files] = $em->getRepository(Car::class)
            ->getInvoiceFiles($start, $length, $columnSort, $sortType, $searchDate);

        $data = [];
        foreach ($files as $file) {
            $data[] = [
                'invoiceFileName' => $file->getInvoiceFileName(),
                'carInvoiceDate'  => $file->getCarInvoiceDate()->format('d.m.y'),
            ];
        }

        return JsonResponse::create([
            'data'            => $data,
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
        ]);
    }
}