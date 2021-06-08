<?php

namespace AppBundle\Controller;

use AdminBundle\Entity\Car;
use AdminBundle\Entity\Currency;
use AdminBundle\Entity\UserOrder;
use AdminBundle\Enum\CarShowPrices;
use AppBundle\Traits\CarTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OrderController
 *
 * @Route("/order")
 *
 * @package AppBundle\Controller
 */
class OrderController extends Controller
{
    use CarTrait;

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
     * @Route("/ajax-data")
     *
     * @param Request $request A Request instance.
     *
     * @return JsonResponse
     */
    public function ajaxDataForUser(
        Request $request
    ): JsonResponse {
        $start = $request->query->get('start');
        $length = $request->query->get('length');

        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        [$count, $cars] = $em->getRepository(Car::class)
            ->getUserCars($start, $length, $user->getId());

        $data = [];
        foreach ($cars as $car) {
            $showPrice = $car->getShowPrice();
            $pricePln = '';
            switch ($showPrice) {
                case CarShowPrices::PRISE:
                    $pricePln = $car->getMinimumSellingPrice();
                    break;
                case CarShowPrices::PRISE_1:
                    $pricePln = $car->getPriceRoleFive();
                    break;
                case CarShowPrices::PRISE_2:
                    $pricePln = $car->getPriceRoleSix();
                    break;
                case CarShowPrices::PRISE_3:
                    $pricePln = $car->getPriceRoleSeven();
                    break;
            }

            $pricePln = $pricePln !== '' ? number_format($pricePln, 0, '.', '.') . ' PLN' : $pricePln;

            $complStandart = '';
            if (($version = $car->getVersionGerman()) !== null) {
                $complStandart = $version->getStandardComplectation() !== null
                    ? $version->getStandardComplectation()->getGerman()
                    : '';
            }

            $data[] = [
                'carId' => $car->getId(),
                'brand' => $car->getBrand() !== null ? $car->getBrand()->getTitle() : '',
                'model' => $car->getModel() !== null ? $car->getModel()->getTitle() : '',
                'versionGerman' => $car->getVersionGerman() !== null ? $car->getVersionGerman()->getGerman() : '',
                'colorGerman' => $car->getColorGerman() !== null ? $car->getColorGerman()->getGerman() : '',
                'date' => $this->getDate($car),
                'vinNumber' => $this->getVinNumber($car),
                'preisePln' => $pricePln,
                'complectationStandart' => $complStandart,
                'complectationOther' => $car->getComplectationGerman() !== null ? $car->getComplectationGerman() : '',
                'modelImageName' => $car->getModel() !== null ? $car->getModel()->getFileName() : '',
                'ez' => $car->getCarRegistration() !== null && $car->getCarMileage() !== '' ? $car->getCarRegistration()->format('d.m.Y') : ''
            ];
        }

        return JsonResponse::create([
            'data'            => $data,
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
        ]);
    }
}