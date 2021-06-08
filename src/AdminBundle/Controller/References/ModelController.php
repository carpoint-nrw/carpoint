<?php

namespace AdminBundle\Controller\References;

use AdminBundle\Traits\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ModelController
 *
 * @Route("/model")
 *
 * @package AdminBundle\Controller\References
 */
class ModelController extends AbstractReferencesController
{
    use FileUploader;

    /**
     * @var string
     */
    protected $modelAbsolutePath;

    /**
     * ModelController constructor.
     *
     * @param EntityManagerInterface $em
     * @param string $modelAbsolutePath
     */
    public function __construct(EntityManagerInterface $em, string $modelAbsolutePath)
    {
        parent::__construct($em);
        $this->modelAbsolutePath = $modelAbsolutePath;
    }

    /**
     * @param Request $request
     * @param string  $type
     * @param int     $id
     *
     * @return array|Response
     */
    protected function newAndEditHandle(Request $request, string $type, int $id = 0)
    {
        if ($id) {
            if (!$entity = $this->em->getRepository($this->entity)->find($id))
                throw $this->createNotFoundException();
        }else
            $entity = new $this->entity();

        $form = $this
            ->createForm($this->entityForm, $entity)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->upload($entity);
            $this->em->persist($entity);
            $this->em->flush();

            return $this->redirectToRoute($this->indexRoute);
        }

        return [
            'form' => $form->createView(),
            'entity' => $this->entityReadableName,
            'indexRoute' => $this->indexRoute,
            'type' => $type,
        ];
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
        $search = $request->query->get('search')['value'];
        $columnSort = $columns[$order[0]['column']]['name'] === 'edit'
            ? 'title'
            : $columns[$order[0]['column']]['name'];
        $sortType = $order[0]['dir'];

        $em = $this->getDoctrine()->getManager();

        [$count, $data] = $em->getRepository('AdminBundle\Entity\References\\' . $this->entityName)
            ->getData($start, $length, $columnSort, $sortType, $search);

        $result = [];
        foreach ($data as $elem) {
            $result[] = [
                'entityId' => $elem->getId(),
                'title' => $elem->getTitle(),
                'brand' => $elem->getBrand()->getTitle()
            ];
        }

        return JsonResponse::create([
            'data'            => $result,
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
        ]);
    }
}