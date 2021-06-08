<?php

namespace AdminBundle\Controller\Ajax;

use AdminBundle\Entity\Car;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class AjaxSelect2Controller
 *
 * @Route("/ajax-select2")
 *
 * @package AdminBundle\Controller\Ajax
 */
class AjaxSelect2Controller extends Controller
{
    /**
     * @Route("/firm-names")
     *
     * @param Request $request A Request instance.
     *
     * @return JsonResponse
     */
    public function getCarFirmNames(Request $request): JsonResponse
    {
        $term    = $request->query->get('term', null);
        $em      = $this->getDoctrine()->getManager();
        $cars    = $em->getRepository(Car::class)->getCarFirmNames();
        $carKeys = [];
        foreach ($cars as $key => $car) {
            if ($term !== null && mb_stristr($car['firma'], $term) === false) {
                continue;
            }
            $id = $car['id'];
            unset($car['id']);
            $carKeys[$id] = $car;
        }

        $carsUnique = array_unique($carKeys, SORT_REGULAR);

        $result = [];
        foreach ($carsUnique as $carId => $carUnique) {
            $result[] = [
                'id'   => $carId,
                'text' => $carUnique['firma'],
            ];
        }

        return JsonResponse::create($result);
    }
}