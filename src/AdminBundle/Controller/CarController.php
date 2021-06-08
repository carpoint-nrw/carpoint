<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Buyer;
use AdminBundle\Entity\Car;
use AdminBundle\Entity\Currency;
use AdminBundle\Entity\References\Forwarder;
use AdminBundle\Entity\References\Location;
use AdminBundle\Entity\References\PlaceOfIssue;
use AdminBundle\Entity\References\TargetUnload;
use AdminBundle\Entity\User\User;
use AdminBundle\Entity\User\UserOrderNumber;
use AdminBundle\Enum\CarConditionEnum;
use AdminBundle\Enum\CarStatusEnum;
use AdminBundle\Enum\UserRoleEnum;
use AdminBundle\Services\CarUpdater;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class CarController
 *
 * @Route("/cars")
 *
 * @package AdminBundle\Controller
 */
class CarController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var string
     */
    private $carInvoicePath;

    /**
     * @var CarUpdater
     */
    private $carUpdater;

    /**
     * CarController constructor.
     *
     * @param EntityManagerInterface $em
     * @param string                 $carInvoicePath
     * @param CarUpdater             $carUpdater
     */
    public function __construct(
        EntityManagerInterface $em,
        string $carInvoicePath,
        CarUpdater $carUpdater
    ) {
        $this->em             = $em;
        $this->carInvoicePath = $carInvoicePath;
        $this->carUpdater = $carUpdater;
    }

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
        $car = new Car();
        $form = $this
            ->createForm(UserRoleEnum::getCarFormType($this->getUser()->getRole()), $car, [
                'attr' => ['type' => 'new']
            ])
            ->handleRequest($request);

        $currency = $this->em->getRepository(Currency::class)->findBy([], ['id' => 'desc'], 1);
        $currency = array_shift($currency);

        if ($form->isSubmitted() && $form->isValid()) {
            $vinNumber = $car->getVinNumber();
            $length    = iconv_strlen(trim($vinNumber));
            if ($length !== 17) {
                return [
                    'form'        => $form->createView(),
                    'carId'       => $car->getId(),
                    'currency'    => $currency !== null ? $currency->getOurCurrency() : 0,
                    'error'       => count($form->getErrors(true)),
                    'customError' => 'Minimum length of vin number 17 characters'
                ];
            }

            $car  = $this->carpointCarSold($car);
            $car  = $this->carlineCarSold($car);

            $user = $this->getUser();
            $car->setUploader($user);

            if ($car->isPay5() === true) {
                $car->setDatumPayFour((new \DateTime())->setTime(0, 0, 0));
            }

            $this->em->persist($car);
            $this->em->flush();

            return $this->redirectToRoute('admin_car_index');
        }

        return [
            'form' => $form->createView(),
            'currency' => $currency !== null ? $currency->getOurCurrency() : 0,
            'error'    => count($form->getErrors(true)),
        ];
    }

    /**
     * @Route("/edit/{id}", requirements={"id"="\d+"}, defaults={ "id": "0" })
     * @Template
     *
     * @param Request $request A http Request instance.
     * @param string  $id      Car id.
     *
     * @return Response|array
     */
    public function editAction(Request $request, string $id)
    {
        $car = $this->em->getRepository(Car::class)->find($id);
        if (!$car) {
            throw $this->createNotFoundException('Car not found');
        }

        $paid                = $car->isPaid();
        $pay5                = $car->isPay5();
        $carConditionCurrent = $car->getCarCondition();
        $carCustomer         = $car->getCustomer() !== null ? $car->getCustomer()->getTitle() : null;
        $carCustomerType     = $carCustomer === 'CP' ? true : false;
        $form                = $this
            ->createForm(UserRoleEnum::getCarFormType($this->getUser()->getRole()), $car, [
                'attr' => ['type' => 'edit', 'editCustomer' => $carCustomer]
            ])
            ->handleRequest($request);

        $currency = $this->em->getRepository(Currency::class)->findBy([], ['id' => 'desc'], 1);
        $currency = array_shift($currency);

        if ($form->isSubmitted() && $form->isValid()) {
            $carInvoiceNumber = $car->getCarInvoiceNumber();
            if ($carInvoiceNumber !== null) {
                $chekcCar = $this->em->getRepository(Car::class)->findOneBy(
                    [
                        'carInvoiceNumber' => $carInvoiceNumber
                    ]
                );

                if ($chekcCar !== null && $chekcCar->getId() !== $car->getId()) {
                    return [
                        'form'        => $form->createView(),
                        'carId'       => $car->getId(),
                        'currency'    => $currency !== null ? $currency->getOurCurrency() : 0,
                        'error'       => count($form->getErrors(true)),
                        'customError' => 'Rechnungsnummer duplicated'
                    ];
                }
            }
            $proformaNumber = $car->getProformaNumber();
            if ($proformaNumber !== null) {
                $chekcCar = $this->em->getRepository(Car::class)->findOneBy(
                    [
                        'proformaNumber' => $proformaNumber
                    ]
                );

                if ($chekcCar !== null && $chekcCar->getId() !== $car->getId()) {
                    return [
                        'form'        => $form->createView(),
                        'carId'       => $car->getId(),
                        'currency'    => $currency !== null ? $currency->getOurCurrency() : 0,
                        'error'       => count($form->getErrors(true)),
                        'customError' => 'Prof-Rechnungsnummer duplicated'
                    ];
                }
            }

            $vinNumber = $car->getVinNumber();
            $length    = iconv_strlen(trim($vinNumber));
            if ($length !== 17) {
                return [
                    'form'        => $form->createView(),
                    'carId'       => $car->getId(),
                    'currency'    => $currency !== null ? $currency->getOurCurrency() : 0,
                    'error'       => count($form->getErrors(true)),
                    'customError' => 'Minimum length of vin number 17 characters'
                ];
            }

            $user = $this->getUser();
            if ($carConditionCurrent !== $car->getCarCondition()) {
                $car
                    ->setSalesman($user)
                    ->setDateOfBooking(new \DateTime());
            }
            $car = $this->carpointCarSold($car);
            $car = $this->carlineCarSold($car);

            if ($pay5 === false && $car->isPay5() === true) {
                $car->setDatumPayFour((new \DateTime())->setTime(0, 0, 0));
            }


            $kaufer = $car->getUser();
            if (
                $kaufer !== null
                && $car->getCarCondition() === CarConditionEnum::SOLD
                && !in_array($kaufer->getFirmNumber(), ['Lichtblick GmbH', 'Carpoint GmbH'])
                && ($targetUnload = $this->em->getRepository(TargetUnload::class)
                    ->findOneBy(['title' => 'Klient'])) !== null
                && $car->getTargetUnload() !== $targetUnload
                && ($car->getTargetUnload() !== null ? $car->getTargetUnload()->getTitle() !== 'x' : true)
            ) {
                $car->setTargetUnload($targetUnload);

                $placeOfIssue = $this->em->getRepository(PlaceOfIssue::class)
                    ->findOneBy(['title' => 'Anlieferung zum Kunden']);
                if (
                    $placeOfIssue !== null
                    && $car->getPlaceOfIssue() !== $placeOfIssue
                ) {
                    $car->setPlaceOfIssue($placeOfIssue);
                }
            }

            $carTargetUnload = $car->getTargetUnload();
            $carPlaceOfIssue = $car->getPlaceOfIssue();
            if (
                $car->getCarCondition() === CarConditionEnum::SOLD
                && !in_array($kaufer->getFirmNumber(), ['Lichtblick GmbH', 'Carpoint GmbH'])
                && $carTargetUnload === 'Klient'
                && ($placeOfIssue = $this->em->getRepository(PlaceOfIssue::class)
                    ->findOneBy(['title' => 'Anlieferung zum Kunden'])) !== null
                && $carPlaceOfIssue !== $placeOfIssue
            ) {
                $car->setPlaceOfIssue($placeOfIssue);
            } elseif (
                $car->getCarCondition() === CarConditionEnum::SOLD
                && !in_array($kaufer->getFirmNumber(), ['Lichtblick GmbH', 'Carpoint GmbH'])
                && $carPlaceOfIssue === 'Anlieferung zum Kunden'
                && ($targetUnload = $this->em->getRepository(TargetUnload::class)
                    ->findOneBy(['title' => 'Klient'])) !== null
                && $carTargetUnload !== $targetUnload
                && ($car->getTargetUnload() !== null ? $car->getTargetUnload()->getTitle() !== 'x' : true)
            ) {
                $car->setTargetUnload($targetUnload);
            }

            $this->carUpdater->checkCarUpdate($user, $car, $this->em);

            $this->em->persist($car);
            $this->em->flush();

            $buttonName = $form->getClickedButton()->getName();
            switch ($buttonName) {
                case 'saveCarpointPdf':
                    return $this->redirectToRoute('admin_carexportpdf_deedexport', ['id' => $car->getId()]);
                case 'saveCarlinePdf':
                    return $this->redirectToRoute('app_carexportpdf_deedexport', ['carId' => $car->getId()]);
                case 'saveInvoiceAccountPdf':
                    return $this->redirectToRoute('admin_carexportpdf_invoiceaccountexport', ['id' => $car->getId()]);
                case 'certificate':
                    return $this->redirectToRoute('admin_carexportpdf_certificateexport', ['id' => $car->getId()]);
                default:
                    return $this->redirectToRoute('admin_car_index');
            }
        }

        $car->setEditDate(new \DateTime());
        $this->em->persist($car);
        $this->em->flush();

        return [
            'form'     => $form->createView(),
            'carId'    => $car->getId(),
            'currency' => $currency !== null ? $currency->getOurCurrency() : 0,
            'error'    => count($form->getErrors(true)),
        ];
    }

    /**
     * @Route("/delete")
     * @Template
     *
     * @param Request $request Car id.
     *
     * @return Response
     */
    public function deleteAction(Request $request): Response
    {
        $carId = $request->request->get('carId', 0);
        $car = $this->em->getRepository(Car::class)->find($carId);

        if ($car !== null) {
            $this->em->remove($car);
            $this->em->flush();
        }

        return $this->ajaxData($request);
    }

    /**
     * @Route("/archive/{id}", requirements={"id"="\d+"}, defaults={ "id": "0" })
     * @Template
     *
     * @param Request $request A http Request instance.
     *
     * @return Response
     */
    public function archiveAction(Request $request): Response
    {
        $carIds = $request->request->get('carIds', []);
        if (empty($carIds)) {

            return $this->ajaxData($request);
        }

        $carIds = explode(',', $carIds);

        $cars = $this->em->getRepository(Car::class)->findby([
            'id' => $carIds
        ]);
        if (empty($cars)) {
            throw $this->createNotFoundException('Cars not found');
        }

        $user = $this->getUser();
        foreach ($cars as $car) {
            $car->setStatus(CarStatusEnum::ARCHIVE);
            $car->setAddedToArchive(new \DateTime());

            $user->getLocale() === 'de'
                ? $car->setAddedToArchiveDe(new \DateTime())
                : $car->setAddedToArchivePl(new \DateTime());

            $this->em->persist($car);
        }

        $this->em->flush();

        return $this->ajaxData($request);
    }

    /**
     * @Route("/car-condition")
     * @Template
     *
     * @param Request    $request    Car id.
     * @param CarUpdater $carUpdater Car Updater service.
     *
     * @return Response
     */
    public function carConditionAction(Request $request, CarUpdater $carUpdater): Response
    {
        $carId        = $request->request->get('carId', 0);
        $carCondition = $request->request->get('carCondition', '');
        $car          = $this->em->getRepository(Car::class)->find($carId);

        if ($car !== null) {
            $user = $this->getUser();

            $car
                ->setCarCondition(CarConditionEnum::getCarCondition($carCondition))
                ->setSalesman($user)
                ->setDateOfBooking(new \DateTime());

            if (
                strtolower($carCondition) === CarConditionEnum::SOLD
                && ($kaufer = $car->getUser()) !== null
                && !in_array($kaufer->getFirmNumber(), ['Lichtblick GmbH', 'Carpoint GmbH'])
                && ($targetUnload = $this->em->getRepository(TargetUnload::class)
                    ->findOneBy(['title' => 'Klient'])) !== null
                && $car->getTargetUnload() !== $targetUnload
                && ($car->getTargetUnload() !== null ? $car->getTargetUnload()->getTitle() !== 'x' : true)
            ) {
                $car->setTargetUnload($targetUnload);

                $placeOfIssue = $this->em->getRepository(PlaceOfIssue::class)
                    ->findOneBy(['title' => 'Anlieferung zum Kunden']);
                if (
                    $placeOfIssue !== null
                    && $car->getPlaceOfIssue() !== $placeOfIssue
                ) {
                    $car->setPlaceOfIssue($placeOfIssue);
                }
            }

            $this->em->persist($car);

            $this->carUpdater->checkCarUpdate($this->getUser(), $car, $this->em);
            $this->em->flush();
        }

        return $this->ajaxData($request);
    }

    /**
     * @Route("/change-checkbox")
     * @Template
     *
     * @param Request $request Car id.
     *
     * @return Response
     */
    public function changeCheckbox(Request $request): Response
    {
        try {
            $carId       = $request->request->get('carId', 0);
            $changeValue = $request->request->get('changeValue', '');
            $changeField = $request->request->get('changeField', '');
            $car         = $this->em->getRepository(Car::class)->find($carId);

            if ($car !== null) {
                if ($changeValue === 'true') {
                    $changeValue = true;
                } elseif ($changeValue === 'false') {
                    $changeValue = false;
                } else {
                    throw new NotFoundHttpException();
                }
                if ($changeField === 'pay') {
                    $car->setPayClick($changeValue ? (new \DateTime())->setTime(0, 0, 0) : null);
                    if ($car->getData2() === null && $changeValue === true) {
                        $car->setData2((new \DateTime())->setTime(0, 0, 0));
                    }
                }
                if ($changeField === 'paid') {
                    $car->setPaidClick($changeValue ? (new \DateTime())->setTime(0, 0, 0) : null);
                }
                if ($changeField === 'paidSuccess') {
                    if ($car->getInvoiceDate() === null && $changeValue === true) {
                        $car->setInvoiceDate((new \DateTime())->setTime(0, 0, 0));
                    }
                }
                if ($changeField === 'paid' && $changeValue === true) {
                    $car->setAnkauf((new \DateTime())->setTime(0, 0, 0));
                } elseif ($changeField === 'paid' && $changeValue === false) {
                    $car->setAnkauf(null);
                }
                if ($changeField === 'pay5') {
                    $car->setDatumPayFour((new \DateTime())->setTime(0, 0, 0));
                }
                if ($changeField === 'zahldatumPay') {
                    $car->setZahldatum((new \DateTime())->setTime(0, 0, 0));
                }
                $setter = 'set'.ucfirst($changeField);
                $car->$setter($changeValue);

                $this->em->persist($car);
                $this->carUpdater->checkCarUpdate($this->getUser(), $car, $this->em);
                $this->em->flush();
            }

            return $this->ajaxData($request);
        } catch (\Throwable $exception) {
            return $this->ajaxData($request);
        }
    }

    /**
     * @Route("/change-select-input")
     * @Template
     *
     * @param Request $request Car id.
     *
     * @return Response
     */
    public function changeSelectInput(Request $request): Response
    {
        try {
            $carId       = $request->request->get('carId', 0);
            $changeValue = $request->request->get('changeValue', '');
            $changeField = $request->request->get('changeField', '');
            $car         = $this->em->getRepository(Car::class)->find($carId);

            if ($car !== null) {
                $data = false;
                switch ($changeField) {
                    case 'targetUnload':
                        $data = $this->em->getRepository(TargetUnload::class)->find($changeValue);
                        if ($data === null) {
                            break;
                        }
                        $user = $this->getUser();
                        if ($data->getTitle() === 'x') {
                            $currentTargetUnload = $car->getTargetUnload() !== null ? $car->getTargetUnload()->getTitle() : null;
                            $location = $this->em->getRepository(Location::class)->findOneBy([
                                'title' => $currentTargetUnload,
                            ]);
                            if ($location !== null) {
                                $car->setLocation($location);
                            }
                        }

                        $placeOfIssue = $this->em->getRepository(PlaceOfIssue::class)
                            ->findOneBy(['title' => 'Anlieferung zum Kunden']);
                        $kaufer = $car->getUser();
                        if (
                            $car->getCarCondition() === CarConditionEnum::SOLD
                            && !in_array($kaufer->getFirmNumber(), ['Lichtblick GmbH', 'Carpoint GmbH'])
                            && $placeOfIssue !== null
                            && $car->getPlaceOfIssue() !== $placeOfIssue
                            && $data->getTitle() === 'Klient'
                        ) {
                            $car->setPlaceOfIssue($placeOfIssue);
                        }
                        break;
                    case 'forwarder':
                        $data = $this->em->getRepository(Forwarder::class)->find($changeValue);
                        break;
                    case 'location':
                        $data = $this->em->getRepository(Location::class)->find($changeValue);
                        break;
                    case 'user':
                        $data = $this->em->getRepository(User::class)->find($changeValue);

                        if (
                            $data !== null
                            && $car->getCarCondition() === CarConditionEnum::SOLD
                            && !in_array($data->getFirmNumber(), ['Lichtblick GmbH', 'Carpoint GmbH'])
                            && ($targetUnload = $this->em->getRepository(TargetUnload::class)
                                ->findOneBy(['title' => 'Klient'])) !== null
                            && $car->getTargetUnload() !== $targetUnload
                            && ($car->getTargetUnload() !== null ? $car->getTargetUnload()->getTitle() !== 'x' : true)
                        ) {
                            $car->setTargetUnload($targetUnload);

                            $placeOfIssue = $this->em->getRepository(PlaceOfIssue::class)
                                ->findOneBy(['title' => 'Anlieferung zum Kunden']);
                            if (
                                $placeOfIssue !== null
                                && $car->getPlaceOfIssue() !== $placeOfIssue
                            ) {
                                $car->setPlaceOfIssue($placeOfIssue);
                            }
                        }

                        break;
                    default:
                        $data = null;
                }
                if ($data === false) {
                    return $this->ajaxData($request);
                }
                $setter = 'set' . ucfirst($changeField);
                $car->$setter($data);
                $this->em->persist($car);
                $this->carUpdater->checkCarUpdate($this->getUser(), $car, $this->em);
                $this->em->flush();
            }

            return $this->ajaxData($request);
        } catch (\Throwable $exception) {
            return $this->ajaxData($request);
        }
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
            $carId       = $request->request->get('carId', 0);
            $changeValue = $request->request->get('changeValue', '');
            $changeField = $request->request->get('changeField', '');
            $car         = $this->em->getRepository(Car::class)->find($carId);

            if ($car !== null) {
                $setter = 'set'.ucfirst($changeField);
                if ($changeField === 'downloadDate') {
                    if ($changeValue === '') {
                        $changeValue = null;
                    } else {
                        $dateArray = explode('.', $changeValue);
                        $changeValue = (new \DateTime())
                            ->setDate(date('Y'), $dateArray[1], $dateArray[0])
                            ->setTime(00, 00, 00);
                        if (!$changeValue instanceof \DateTime) {
                            return $this->ajaxData($request);
                        }
                    }
                } elseif ($changeField === 'shippingCost') {
                    $changeValue = str_replace('.', '', $changeValue);
                    $type = '';
                    if (mb_stristr($changeValue, '€') !== false) {
                        $type = 'EUR';
                        $changeValue = str_replace('€', '', $changeValue);
                    }
                    if (mb_stristr($changeValue, 'zl') !== false) {
                        $type = 'PLN';
                        $changeValue = str_replace('zl', '', $changeValue);
                    }
                    $changeValue = trim($changeValue);
                    if ($type !== '') {
                        $car->setShippingCostType($type);
                    }
                } elseif ($changeField === 'importTax') {
                    $changeValue = str_replace('zl', '', $changeValue);
                    $changeValue = trim($changeValue);
                    if ($changeValue === '') {
                        $changeValue = null;
                    }
                } elseif ($changeField === 'client') {
                    if ($car->getFirma() !== null && $car->getFirma() !== '') {
                        $setter = 'setFirma';
                    } else {
                        $setter = 'setLastName';
                    }
                } elseif ($changeField === 'invoiceNumber') {
                    if (
                        (mb_strtolower(trim($changeValue)) === 'x' || mb_strtolower(trim($changeValue)) === 'pro')
                        && $car->getPaymentDate() === null
                    ) {
                        $car->setPaymentDate((new \DateTime())->setTime(0, 0, 0));
                    }
                }

                $car->$setter($changeValue);
                $this->em->persist($car);
                $this->carUpdater->checkCarUpdate($this->getUser(), $car, $this->em);
                $this->em->flush();
            }

            return $this->ajaxData($request);
        } catch (\Throwable $exception) {
            return $this->ajaxData($request);
        }
    }

    /**
     * @Route("/remove-invoice-file/{id}", requirements={"id"="\d+"}, defaults={ "id": "0" })
     * @Template
     *
     * @param Request $request A http Request instance.
     * @param string  $id      Car id.
     *
     * @return Response
     */
    public function removeInvoiceFileAction(Request $request, string $id): Response
    {
        $car = $this->em->getRepository(Car::class)->find($id);
        if (!$car) {
            throw $this->createNotFoundException('Car not found');
        }

        $fileName = $car->getInvoiceFileName();
        if ($fileName !== null) {
            $car->setInvoiceFileName(null);
            $this->em->persist($car);
            $this->em->flush();
        }

        if (file_exists($this->carInvoicePath.'/'.$fileName)) {
            unlink($this->carInvoicePath.'/'.$fileName);
        }

        return $this->redirect($request->headers->get('referer'));
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
        $columnSearch   = $request->request->get('columnSearch', []);
        $paramLength    = $request->request->get('paramLength');
        if ($paramLength === 'true') {
            $length = '5000';
        }

        $user           = $this->getUser();
        [$count, $cars] = $this->em->getRepository(Car::class)
            ->getCars($start, $length, $columnSort, $sortType, $search, $user, CarStatusEnum::SALE, $filters, $columnSearch);

        $dataService    = UserRoleEnum::getCarsTableDataService($user->getRole());
        $data           = (new $dataService($this->em))->getData($cars, $user);

        return JsonResponse::create([
            'data'            => $data,
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
        ]);
    }

    /**
     * @param Car $car
     *
     * @return Car
     */
    private function carpointCarSold(Car $car): Car
    {
        $sellingPrice = $car->getSellingPrice();
        $lastName     = $car->getLastName();
        if ($sellingPrice === null || $lastName === null) {
            return $car;
        }

        if ($car->getDischarge() === null) {
            $maxDischarge = $this->em->getRepository(Car::class)->findMaxDischarge();
            if ($maxDischarge === null) {
                $maxDischarge = 30000;
            } else {
                $maxDischarge = (int) $maxDischarge;
                if ($maxDischarge < 30000) {
                    $maxDischarge = 30000;
                }
                $maxDischarge++;
            }
            $car->setDischarge($maxDischarge);
        }

        $user = $this->getUser();
        if ($car->getSeller() === null) {
            $car->setSeller($user);
        }

        return $car;
    }

    /**
     * @param Car $car
     *
     * @return Car
     */
    private function carlineCarSold(Car $car): Car
    {
        $buyer     = $car->getUser();
        $salePrice = $car->getsalePriceWithOutVAT();

        if ($buyer === null || $salePrice === null) {
            $car->setCarlineDate(null);
            $car->setCarlineNumber(null);

            return $car;
        }

        if ($buyer !== null && $salePrice !== null && $car->getCarlineDate() === null && $car->getCarlineNumber() === null) {
            $car->setCarlineDate((new \DateTime())->setTime(0, 0, 0));

            $userOrderNumber = $this->em->getRepository(UserOrderNumber::class)
                ->findOneBy(['user' => $buyer, 'car' => $car]);
            if ($userOrderNumber !== null) {
                $maxCarNumber = $userOrderNumber->getNumber();
            } else {
                $maxCarNumber       = $this->em->getRepository(Car::class)->findMaxCarlinenumber();
                $maxUserOrderNumber = $this->em->getRepository(UserOrderNumber::class)->findMaxCarlinenumber();
                if ($maxCarNumber === null) {
                    $maxCarNumber = 1001;
                } else {
                    $maxCarNumber = (int) $maxCarNumber;
                    $maxCarNumber++;
                }
                if ($maxUserOrderNumber === null) {
                    $maxUserOrderNumber = 1001;
                } else {
                    $maxUserOrderNumber = (int) $maxUserOrderNumber + 1;
                }

                if ($maxUserOrderNumber > $maxCarNumber) {
                    $maxCarNumber = $maxUserOrderNumber;
                }

                $userOrderNumber = new UserOrderNumber();
                $userOrderNumber->setCar($car);
                $userOrderNumber->setUser($buyer);
                $userOrderNumber->setNumber($maxCarNumber);
                $this->em->persist($userOrderNumber);
            }
            $car->setCarlineNumber($maxCarNumber);
        }

        $user = $this->getUser();
        if ($car->getCarCondition() === CarConditionEnum::SOLD && $car->getSeller() === null) {
            $car->setSeller($user);
        }

        return $car;
    }
}