<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\CarEditHistory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CarEditHistoryController
 *
 * @Route("/car-edit-history")
 *
 * @package AdminBundle\Controller
 */
class CarEditHistoryController extends Controller
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
            ? 'editDate'
            : $columns[$order[0]['column']]['name'];
        $sortType = $order[0]['dir'];

        $em = $this->getDoctrine()->getManager();

        [$count, $carEditHistory] = $em->getRepository(CarEditHistory::class)
            ->getGetEditHistory($start, $length, $columnSort, $sortType, $search);

        $user = $this->getUser();

        $data = [];
        foreach ($carEditHistory as $history) {
            if ($user->getLocale() === null) {
                $column = null;
            } else {
                $column = $user->getLocale() === 'de' ? $history->getColumnGerman() : $history->getColumnPolish();
            }
            $data[] = [
                'id'        => $history->getId(),
                'editDate'  => $history->getEditDate() === null ? null : $history->getEditDate()->format('d.m.Y H:i:s'),
                'admin'     => $history->getAdmin()->getFullName(),
                'vinNumber' => $history->getCar() === null ? null : $history->getCar()->getVinNumber(),
                'column'    => $column,
                'oldValue'  => $history->getOldValue(),
                'newValue'  => $history->getNewValue(),
            ];
        }

        return JsonResponse::create([
            'data'            => $data,
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
        ]);
    }
}