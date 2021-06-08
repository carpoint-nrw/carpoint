<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\CarFileType;
use AdminBundle\Form\CarFileTypeFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CarFileTypeController
 *
 * @Route("/car-file-type")
 *
 * @package AdminBundle\Controller
 */
class CarFileTypeController extends Controller
{
    /**
     * @Route("")
     * @Template
     *
     * @return Response|array
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/new")
     * @Template
     *
     * @param Request $request A http Request instance.
     *
     * @return array|Response
     */
    public function newAction(Request $request)
    {
        return $this->newAndEditHandle($request, 'New');
    }

    /**
     * @Route("/edit/{id}", requirements={"id"="\d+"}, defaults={ "id": "0" })
     * @Template
     *
     * @param Request $request A http Request instance.
     * @param integer $id      Entity id.
     *
     * @return array|Response
     */
    public function editAction(Request $request, int $id)
    {
        return $this->newAndEditHandle($request, 'Edit', $id);
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
        $em = $this->getDoctrine()->getManager();
        if ($id) {
            if (!$entity = $em->getRepository(CarFileType::class)->find($id))
                throw $this->createNotFoundException();
        }else
            $entity = new CarFileType();

        $form = $this
            ->createForm(CarFileTypeFormType::class, $entity)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirectToRoute('admin_carfiletype_index');
        }

        return [
            'form' => $form->createView(),
            'type' => $type,
        ];
    }

    /**
     * @Route("/delete", methods={ "GET" })
     * @Template
     *
     * @param Request $request User id.
     *
     * @return Response
     */
    public function deleteAction(Request $request): Response
    {
        $typeId = $request->query->get('typeId', 0);
        $em     = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(CarFileType::class)->find($typeId);

        if ($entity !== null) {
            $em->remove($entity);
            $em->flush();
        }

        return $this->ajaxData($request);
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
        $start      = $request->query->get('start');
        $length     = $request->query->get('length');
        $order      = $request->query->get('order');
        $columns    = $request->query->get('columns');
        $columnSort = $columns[$order[0]['column']]['name'] === 'edit'
            ? 'type' : $columns[$order[0]['column']]['name'];
        $sortType   = $order[0]['dir'];

        $em = $this->getDoctrine()->getManager();
        [$count, $types] = $em->getRepository(CarFileType::class)
            ->getTypes($start, $length, $columnSort, $sortType);

        $data = [];
        foreach ($types as $type) {
            $data[] = [
                'typeId' => $type->getId(),
                'type'   => $type->getType() !== null ? $type->getType() : '',
            ];
        }

        return JsonResponse::create([
            'data'            => $data,
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
        ]);
    }
}