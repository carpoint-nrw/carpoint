<?php

namespace AppBundle\Controller\Ajax;

use AdminBundle\Entity\Car;
use AppBundle\Traits\CarTrait;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class HomepageFiltersController
 *
 * @Route("/homepage-filters-ajax")
 *
 * @package AppBundle\Controller\Ajax
 */
class HomepageFiltersController extends Controller
{
    use CarTrait;

    /**
     * @Route("")
     *
     * @param Request $request A Request instance.
     *
     * @return JsonResponse
     */
    public function getHomepageFilterData(Request $request): JsonResponse
    {
        $filterName = $request->request->get('filter');
        $filters = $request->request->get('filters', []);
        $searchValue = $request->request->get('searchValue');
        $searchValue = str_ireplace('id', '', $searchValue);

        $em = $this->getDoctrine()->getManager();

        if ($filterName === 'model' || $filterName === 'brand') {
            $filters = [];
        }

        $cars = $em->getRepository(Car::class)
            ->getHomepageCarsForFilters($searchValue, $filters);

        $cars = $this->sortCarsWithSearch($cars, $searchValue);

        $result = [];
        switch ($filterName) {
            case 'brand':
                foreach ($cars as $car) {
                    $brand = $car->getBrand();
                    if ($brand !== null) {
                        $result[] = $brand->getTitle();
                    }
                }
                break;
            case 'model':
                foreach ($cars as $car) {
                    $model = $car->getModel();
                    if ($model !== null) {
                        $result[] = $model->getTitle();
                    }
                }
                break;
            case 'versionGerman':
                foreach ($cars as $car) {
                    $versionGerman = $car->getVersionGerman();
                    if ($versionGerman !== null) {
                        $result[] = $versionGerman->getGerman();
                    }
                }
                break;
            case 'colorGerman':
                foreach ($cars as $car) {
                    $colorGerman = $car->getColorGerman();
                    if ($colorGerman !== null) {
                        $result[] = $colorGerman->getGerman();
                    }
                }
                break;
            case 'date':
                $tempArray = [];
                foreach ($cars as $car) {
                    $date = $car->getDate();
                    if ($date !== null) {
                        $tempArray[] = $car->getDate();
                    }
                }
                sort($tempArray);
                foreach ($tempArray as $elem) {
                    $result[] = $elem->format('d.m.Y');
                }
                break;
        }

        $result = array_unique($result);
        $result = array_values($result);

        return JsonResponse::create($result);
    }
}