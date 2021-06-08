<?php

namespace AppBundle\Controller;

use AdminBundle\Entity\Car;
use AdminBundle\Entity\Currency;
use AdminBundle\Entity\Order;
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
 * Class HomepageController
 *
 * @Route("/")
 *
 * @package AppBundle\Controller
 */
class HomepageController extends Controller
{
    use CarTrait;

    /**
     * @Route("homepage")
     * @Template
     *
     * @return Response|array
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("ajax-add-to-order/{id}", requirements={"id"="\d+"}, defaults={ "id": "0" })
     *
     * @param string $id Car id.
     *
     * @return JsonResponse
     */
    public function ajaxAddToOrder(string $id)
    {
        $user = $this->getUser();
        if ($user === null || $user->accessFrontendSite() === false) {
            return JsonResponse::create(['result' => false]);
        }

        $em = $this->getDoctrine()->getManager();
        $car = $em->getRepository(Car::class)->find($id);
        if ($car === null) {
            return JsonResponse::create(['result' => false]);
        }

        $checkUserOrder = $em->getRepository(UserOrder::class)->findBy([
            'user' => $user->getId(),
            'car' => $car->getId(),
        ]);

        if (!empty($checkUserOrder)) {
            return JsonResponse::create(['result' => false]);
        }

        $userOrder = new UserOrder();
        $userOrder
            ->setCar($car)
            ->setUser($user);

        $em->persist($userOrder);
        $em->flush();

        $userOrders = $em->getRepository(UserOrder::class)->findBy([
            'user' => $user->getId(),
        ]);

        return JsonResponse::create(['result' => count($userOrders)]);
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
        $start = $request->request->get('start');
        $length = $request->request->get('length');
        $order = $request->request->get('order');
        $columns = $request->request->get('columns');
        $search = $request->request->get('search')['value'];
        $filters = $request->request->get('filters', []);
        $columnSort = $request->request->get('columnSort', '');
        $sortType = $request->request->get('sortType', '');
        $search = str_ireplace('id', '', $search);

        $em = $this->getDoctrine()->getManager();
        [$count, $cars] = $em->getRepository(Car::class)
            ->getHomepageCars($start, $length, $columnSort, $sortType, $search, $filters);

        $cars = $this->sortCarsWithSearch($cars, $search);

        $user = $this->getUser();

        $currency = $em->getRepository(Currency::class)->findBy(
            [], ['id'=>'DESC'],1,0
        );

        $data = [];
        foreach ($cars as $car) {
            $pricePln = 'not_authorization';
            $priceEur = 'not_authorization';
            $pricePlnNumber = 0;
            if ($user !== null) {
                $showPrice = $car->getShowPrice();
                $pricePln = '';
                $pricePlnNumber = 0;
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
                $pricePlnNumber = $pricePln === '' ? 0 : round($pricePln);

                $priceEur = '';
                if ($currency !== null) {
                    $priceEur = $pricePln / $currency[0]->getOurCurrency();
                    $priceEur = $priceEur !== '' ? number_format($priceEur, 0, '.', '.') . ' €' : $priceEur;
                }

                $pricePln = $pricePln !== '' ? number_format($pricePln, 0, '.', '.') . ' PLN' : $pricePln;
            }

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
                'preiseEur' => $priceEur,
                'preisePln' => $pricePln,
                'preisePlnNumber' => $pricePlnNumber,
                'complectationStandart' => $complStandart,
                'complectationOther' => $car->getComplectationGerman() !== null ? $car->getComplectationGerman() : '',
                'modelImageName' => $car->getModel() !== null ? $car->getModel()->getFileName() : '',
                'ez' => $car->getCarRegistration() !== null && $car->getCarMileage() !== '' ? $car->getCarRegistration()->format('d.m.Y') : '',
                'km' => $car->getCarMileage() !== null ? $car->getCarMileage() : '',
            ];
        }

        if ($columnSort === 'minimumSellingPrice') {
            uasort($data, function($a, $b) use ($sortType) {
                if ($a['preisePlnNumber'] === $b['preisePlnNumber']) {

                    return 0;
                }

                if ($sortType === 'desc') {
                    return ($a['preisePlnNumber'] < $b['preisePlnNumber']) ? 1 : -1;
                } else {
                    return ($a['preisePlnNumber'] < $b['preisePlnNumber']) ? -1 : 1;
                }
            });

            $data = array_slice($data, $start, $length);
        }

        return JsonResponse::create([
            'data'            => $data,
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
        ]);
    }
}