<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Car;
use AdminBundle\Enum\CarStatusEnum;
use AdminBundle\Enum\UserRoleEnum;
use AdminBundle\Services\ExportCsv\ExportStatisticCsv;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class StatisticsController
 *
 * @Route("/statistic")
 *
 * @package AdminBundle\Controller
 */
class StatisticsController extends Controller
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
     * @Route("/edit/{id}", requirements={"id"="\d+"}, defaults={ "id": "0" })
     * @Template
     *
     * @param Request    $request A http Request instance.
     * @param string     $id      Car id.
     *
     * @return Response|array
     */
    public function editAction(Request $request, string $id)
    {
        $em  = $this->getDoctrine()->getManager();
        $car = $em->getRepository(Car::class)->find($id);
        if (!$car) {
            throw $this->createNotFoundException('Car not found');
        }

        return [
            'carId' => $car->getId(),
        ];
    }

    /**
     * @Route("/statistic-summe")
     *
     * @param Request $request Request.
     *
     * @return JsonResponse
     */
    public function getStatisticSumme(Request $request): JsonResponse
    {
        $search  = $request->request->get('search')['value'];
        $filters = $request->request->get('filters', []);

        ini_set('memory_limit', '1024M');
        $em      = $this->getDoctrine()->getManager();
        $cars    = $em->getRepository(Car::class)
            ->getCarsForStatisticsSummeAndCsv($search, $filters);

        $ekNetto  = 0;
        $ekBrutto = 0;
        $ust      = 0;
        $vkNetto  = 0;
        $vkBrutto = 0;
        $gewinn   = 0;
        foreach ($cars as $car) {
            $ekNetto  = is_float($car->getEkNetto()) ? $ekNetto + $car->getEkNetto() : $ekNetto;
            $ekBrutto = is_float($car->getEkBrutto()) ? $ekBrutto + $car->getEkBrutto() : $ekBrutto;
            $ust      = is_float($car->getUst()) ? $ust + $car->getUst() : $ust;
            $gewinn   = is_float($car->getGewinn()) ? $gewinn + $car->getGewinn() : $gewinn;

            $taxType  = $car->getTaxType() !== null ? $car->getTaxType()->getTitle() : null;
            if (
                $taxType == 'umsatzsteuerfrei nach §4 Nr.1a UStG (Export außerhalb der EU)' ||
                $taxType == 'umsatzsteuerfrei nach §4 Nr.1b UStG (Export innerhalb der EU)'
            ) {
                $vkNetto = is_float($car->getSellingPrice()) ? $vkNetto + $car->getSellingPrice() : $vkNetto;
            } else {
                $vkBrutto = is_float($car->getSellingPrice()) ? $vkBrutto + $car->getSellingPrice() : $vkBrutto;
            }
        }

        $data = [
            'ekNetto'  => $ekNetto !== 0
                ? number_format($car->getGewinn(), 0, '.', '.').' €'
                : $ekNetto.' €',
            'ekBrutto' => $ekBrutto !== 0
                ? number_format($ekBrutto, 0, '.', '.').' €'
                : $ekBrutto.' €',
            'ust'      => $ust !== 0
                ? number_format($ust, 0, '.', '.').' €'
                : $ust.' €',
            'gewinn'   => $gewinn !== 0
                ? number_format($gewinn, 0, '.', '.').' €'
                : $gewinn.' €',
            'vkNetto'  => $vkNetto !== 0
                ? number_format($vkNetto, 0, '.', '.').' €'
                : $vkNetto.' €',
            'vkBrutto' => $vkBrutto !== 0
                ? number_format($vkBrutto, 0, '.', '.').' €'
                : $vkBrutto.' €',
        ];

        return JsonResponse::create($data);
    }

    /**
     * @Route("/change-input-field")
     * @Template
     *
     * @param Request $request Car id.
     *
     * @return Response
     */
    public function changeInputField(Request $request): Response
    {
        try {
            $em          = $this->getDoctrine()->getManager();
            $carId       = $request->request->get('carId', 0);
            $changeValue = $request->request->get('changeValue', '');
            $changeField = $request->request->get('changeField', '');
            $car         = $em->getRepository(Car::class)->find($carId);

            if ($car !== null) {
                $setter = 'set'.ucfirst($changeField);
                $car->$setter($changeValue);
                $em->persist($car);
                $em->flush();
            }

            return $this->ajaxData($request);
        } catch (\Throwable $exception) {
            return $this->ajaxData($request);
        }
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
        $start          = $request->request->get('start');
        $length         = $request->request->get('length');
        $order          = $request->request->get('order');
        $columns        = $request->request->get('columns');
        $search         = $request->request->get('search')['value'];
        $columnSort     = $columns[$order[0]['column']]['name'];
        $sortType       = $order[0]['dir'];
        $filters        = $request->request->get('filters', []);
        $paramLength    = $request->request->get('paramLength');
        if ($paramLength === 'true') {
            $length = '5000';
        }

        $em = $this->getDoctrine()->getManager();
        [$count, $cars] = $em->getRepository(Car::class)
            ->getCarsForStatistics($start, $length, $columnSort, $sortType, $search, $filters);

        $data = [];
        foreach ($cars as $car) {
            if ($car->getFirma() !== null && $car->getFirma() !== '') {
                $client = $car->getFirma();
            } else {
                $client = $car->getLastName() !== null ? $car->getLastName() : '';
            }

            $vkNetto  = null;
            $vkBrutto = null;
            $taxType  = $car->getTaxType() !== null ? $car->getTaxType()->getTitle() : null;
            if (
                $taxType == 'umsatzsteuerfrei nach §4 Nr.1a UStG (Export außerhalb der EU)' ||
                $taxType == 'umsatzsteuerfrei nach §4 Nr.1b UStG (Export innerhalb der EU)'
            ) {
                $vkNetto = $car->getSellingPrice() !== null ? $car->getSellingPrice() : null;
            } else {
                $vkBrutto = $car->getSellingPrice() !== null ? $car->getSellingPrice() : null;
            }

            $zustand = null;
            if ($car->getCarMileage() === null || $car->getCarMileage() === '') {
                $zustand = 'Neu';
            } else {
                $zustand = 'Geb';
            }

            $customer = $car->getCustomer() !== null ? $car->getCustomer()->getTitle() : null;
            if ($customer !== 'LB' && $customer !== 'CL' && $customer !== 'I') {
                $customer = $car->getVendor() !== null ? $car->getVendor()->getTitle() : null;
            }

            $standtage = '';
            if ($car->getAnkauf() !== null && $car->getDatum() !== null) {
                $standtage = date_diff($car->getAnkauf(), $car->getDatum())->days;
            }

            $carInvoiceNumber = $car->getCarInvoiceNumber();
            if ($carInvoiceNumber !== null) {
                $carInvoiceNumberYear = $car->getCarInvoiceNumberYear();
                $carInvoiceNumber = $carInvoiceNumberYear.'-'.str_pad($carInvoiceNumber, 4, 0, STR_PAD_LEFT);
            }

            $data[] = [
                'id'               => $car->getId(),
                'ankauf'           => $car->getAnkauf() !== null ? $car->getAnkauf()->format('d.m.y') : '',
                'brand'            => $car->getBrand() !== null ? $car->getBrand()->getTitle() : null,
                'model'            => $car->getModel() !== null ? $car->getModel()->getTitle() : null,
                'zustand'          => $zustand,
                'vinNumber'        => $car->getVinNumber(),
                'customer'         => $customer,
                'ekNetto'          => $car->getEkNetto() !== null
                    ? number_format($car->getEkNetto(), 0, '.', '.').' €'
                    : null,
                'ekBrutto'         => $car->getEkBrutto() !== null
                    ? number_format($car->getEkBrutto(), 0, '.', '.').' €'
                    : null,
                'ust'              => $car->getUst() !== null
                    ? number_format($car->getUst(), 0, '.', '.').' €'
                    : null,
                'invoiceNumber'    => $car->getInvoiceNumber(),
                'paymentDate'      => $car->getPaymentDate() !== null ? $car->getPaymentDate()->format('d.m.y') : '',
                'preisTr'          => $car->getPreisTr() !== null
                    ? number_format($car->getPreisTr(), 0, '.', '.').' €'
                    : null,
                'datumPayFour'     => $car->getDatumPayFour() !== null ? $car->getDatumPayFour()->format('d.m.y') : '',
                'discharge'        => $car->getDischarge(),
                'datum'            => $car->getDatum() !== null ? $car->getDatum()->format('d.m.y') : '',
                'company'          => $client,
                'proformaNumber'   => $car->getProformaNumber(),
                'proformaDate'     => $car->getProformaDate() !== null ? $car->getProformaDate()->format('d.m.y') : '',
                'carInvoiceNumber' => $carInvoiceNumber,
                'carInvoiceDate'   => $car->getCarInvoiceDate() !== null ? $car->getCarInvoiceDate()->format('d.m.y') : '',
                'paymentType'      => $car->getPaymentType() !== null ? $car->getPaymentType()->getTitle() : null,
                'zahldatum'        => $car->getZahldatum() !== null ? $car->getZahldatum()->format('d.m.y') : '',
                'vkNetto'          => $vkNetto !== null
                    ? number_format($vkNetto, 0, '.', '.').' €'
                    : null,
                'vkBrutto'         => $vkBrutto !== null
                    ? number_format($vkBrutto, 0, '.', '.').' €'
                    : null,
                'gewinn'           => $car->getGewinn() !== null
                    ? number_format($car->getGewinn(), 0, '.', '.').' €'
                    : null,
                'seller'           => $car->getSeller() !== null ? $car->getSeller()->getFullName() : null,
                'infoStatistic'    => $car->getInfoStatistic(),
                'standtage'        => $standtage,
            ];
        }

        return JsonResponse::create([
            'data'            => $data,
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
        ]);
    }

    /**
     * @Route("/export-csv")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function exportCsv(Request $request, ExportStatisticCsv $export): JsonResponse
    {
        $ids  = $request->request->get('ids', []);
        $em   = $this->getDoctrine()->getManager();
        $cars = $em->getRepository(Car::class)->findBy(
            ['id' => explode(',', $ids)],
            ['id' => 'asc']
        );

        if (($fileName = $export->export($cars)) !== null) {
            return JsonResponse::create(['filePath' => $fileName]);
        }

        return JsonResponse::create([], 400);
    }
}