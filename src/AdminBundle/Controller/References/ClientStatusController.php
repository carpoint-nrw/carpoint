<?php

namespace AdminBundle\Controller\References;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ClientStatusController
 *
 * @Route("/client-status")
 *
 * @package AdminBundle\Controller\References
 */
class ClientStatusController extends AbstractReferencesController
{
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
        $search     = $request->query->get('search')['value'];
        $columnSort = $columns[$order[0]['column']]['name'] === 'edit'
            ? 'title'
            : $columns[$order[0]['column']]['name'];
        $sortType   = $order[0]['dir'];

        $em             = $this->getDoctrine()->getManager();
        [$count, $data] = $em->getRepository('AdminBundle\Entity\References\\' . $this->entityName)
            ->getData($start, $length, $columnSort, $sortType, $search);

        $result = [];
        foreach ($data as $elem) {
            $result[] = [
                'entityId'    => $elem->getId(),
                'title'       => $elem->getTitle(),
                'description' => $elem->getDescription(),
            ];
        }

        return JsonResponse::create([
            'data'            => $result,
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
        ]);
    }
}