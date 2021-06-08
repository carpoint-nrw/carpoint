<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Buyer;
use AdminBundle\Form\BuyerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class BuyerController
 *
 * @Route("/buyer")
 *
 * @package AdminBundle\Controller
 */
class BuyerController extends Controller
{
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
     * @Route("/new")
     * @Template
     *
     * @param Request $request A http Request instance.
     *
     * @return array|Response
     */
    public function newAction(Request $request)
    {
        $buyer = new Buyer();
        $form = $this
            ->createForm(BuyerType::class, $buyer)
            ->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($buyer);
            $em->flush();
            return $this->redirectToRoute('admin_buyer_index');
        }
        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/edit/{id}", requirements={"id"="\d+"}, defaults={ "id": "0" })
     * @Template
     *
     * @param Request $request A http Request instance.
     * @param string  $id      User id.
     *
     * @return Response|array
     */
    public function editAction(Request $request, string $id)
    {
        $em = $this->getDoctrine()->getManager();
        $buyer = $em->getRepository(Buyer::class)->find($id);
        if (!$buyer) {
            throw $this->createNotFoundException('Buyer not found');
        }
        $form = $this
            ->createForm(BuyerType::class, $buyer)
            ->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($buyer);
            $em->flush();
            return $this->redirectToRoute('admin_buyer_index');
        }
        return [
            'form'  => $form->createView(),
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
        $buyerId = $request->query->get('buyerId', 0);
        $em = $this->getDoctrine()->getManager();
        $buyer = $em->getRepository(Buyer::class)->find($buyerId);
        if ($buyer !== null) {
            $em->remove($buyer);
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
        $start = $request->query->get('start');
        $length = $request->query->get('length');
        $order = $request->query->get('order');
        $columns = $request->query->get('columns');
        $search = $request->query->get('search')['value'];
        $columnSort = $columns[$order[0]['column']]['name'] === 'edit'
            ? 'firstName'
            : $columns[$order[0]['column']]['name'];
        $sortType = $order[0]['dir'];
        $em = $this->getDoctrine()->getManager();
        [$count, $buyers] = $em->getRepository(Buyer::class)
            ->getBuyers($start, $length, $columnSort, $sortType, $search);
        $data = [];
        foreach ($buyers as $buyer) {
            $data[] = [
                'buyerId' => $buyer->getId(),
                'firstName' => $buyer->getFirstName(),
                'lastName' => $buyer->getLastName(),
                'firmNumber' => $buyer->getFirmNumber(),
                'email' => $buyer->getEmail(),
            ];
        }
        return JsonResponse::create([
            'data'            => $data,
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
        ]);
    }
}