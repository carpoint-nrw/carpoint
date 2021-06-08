<?php

namespace AdminBundle\Controller;

use AdminBundle\DTO\ExportExcelDTO;
use AdminBundle\Entity\Car;
use AdminBundle\Entity\User\User;
use AdminBundle\Enum\CarConditionEnum;
use AdminBundle\Enum\UserRoleEnum;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Class ExportExcelController
 *
 * @Route("/export-excel")
 *
 * @package AdminBundle\Controller
 */
class ExportExcelController extends Controller
{
    private const CAR_COLUMNS = [
        'radioCode', 'vinNumber', 'complectationPolish', 'complectationGerman',
        'carMileage', 'minimumSellingPrice', 'paid', 'documents', 'orderNumber', 'information',
        'standartComplectationPolish', 'standartComplectationGerman', 'ourDiscountPrice', 'invoiceNumber',
        'carlineNumber', 'additionalWork', 'infoStatistic', 'zysk'
    ];

    private const CAR_COLUMNS_DATE = ['carRegistration','completed', 'paymentDate', 'downloadDate', 'datum', 'carlineDate', 'date', 'ankauf', 'datumPayFour', 'zahldatum'];

    private const CAR_COLUMNS_PRICE = [
        'initialVatPrice', 'initialPriceWithOutVat', 'priceRoleFive', 'priceRoleSix', 'priceRoleSeven', 'salePriceWithOutVAT',
        'ekNetto', 'ekBrutto', 'ust', 'gewinn', 'preisTr'
    ];

    private const CAR_JOINED = ['brand', 'model', 'targetUnload', 'location', 'vendor', 'customer', 'paymentType'];

    private const GERMAN_FIELDS = [
        'radioCode' => 'Radio Code', 'carCondition' => 'Reserviert/Verkauft', 'vinNumber' => 'Fahrgestellnummer',
        'complectationPolish' => 'Ausstattung', 'complectationGerman' => 'Sonderausstattung',
        'standartComplectationPolish' => 'Serienausstattung', 'standartComplectationGerman' => 'Serienausstattung',
        'carMileage' => 'KM',
        'minimumSellingPrice' => 'Verkaufspreis mind.', 'paid' => 'Bezahlt', 'documents' => 'Papiere',
        'orderNumber' => 'Bestellnummer', 'information' => 'Info',
        'carRegistration' => 'Vorführwagen', 'completed' => 'Abholtermin', 'paymentDate' => 'Zahltermin',
        'downloadDate' => 'Transport', 'initialVatPrice' => 'Listenpreis brutto',
        'initialPriceWithOutVat' => 'Listenpreis Netto', 'priceRoleFive' => 'Preis 1', 'priceRoleSix' => 'Preis 2',
        'priceRoleSeven' => 'Preis 3',
        'brand' => 'Marke', 'model' => 'Model', 'targetUnload' => 'Lieferort',
        'location' => 'Standort',
        'versionPolish' => 'wersja', 'versionGerman' => 'Ausführung', 'colorPolish' => 'Farbe', 'colorGerman' => 'Farbe',
        'vendor' => 'Lieferant', 'customer' => 'Besteller', 'ourDiscountPrice' => 'Unser Preis',
        'invoiceNumber' => 'Rechnung', 'address1' => 'Ladeort',
        'user' => 'Käufer', 'discount' => 'Rabatt', 'salePriceWithOutVAT' => 'VK CL', 'pay4' => 'pay', 'ekNetto' => 'CP EK',
        'ekBrutto' => 'EK Brutto', 'ust' => 'USt.', 'datum' => 'Datum', 'seller' => 'Verkäufer', 'carlineDate' => 'Datum',
        'carlineNumber' => 'Bestellnummer', 'gewinn' => 'Gewinn', 'additionalWork' => 'Zusatzarbeiten', 'date' => 'Abholterm.',
        'preisb2b' => 'Preis b2b', 'ankauf' => 'Ankauf', 'zustand' => 'Zustand', 'preisTr' => 'Preis Tr.', 'datumPayFour' => 'Datum',
        'company' => 'Nachname oder Firma', 'paymentType' => 'Zahlungsart', 'vkNetto' => ' VK Netto', 'vkBrutto' => 'VK Brutto', 'infoStatistic' => 'Info',
        'rechnungsnr' => 'Rechnungsnr.', 'reDatum' => 'Re. Datum', 'zahldatum' => 'Zahldatum', 'standtage' => 'Standtage',
        'address3' => 'Lieferadresse', 'zysk' => 'zysk'
    ];

    private const POLISH_FIELDS = [
        'radioCode' => 'Radio', 'carCondition' => 'Rezerwacja/Sprzedane', 'vinNumber' => 'NUMER VIN',
        'complectationPolish' => 'Opcje', 'complectationGerman' => 'Sonderausstattung',
        'standartComplectationPolish' => 'Specyfikacje', 'standartComplectationGerman' => 'Serienausstattung',
        'carMileage' => 'Przebeg',
        'minimumSellingPrice' => 'cena ninimalna', 'paid' => 'Data płatności', 'documents' => 'Dokumenty',
        'orderNumber' => 'nr. Zamowenia', 'information' => 'informacje',
        'carRegistration' => 'Demo', 'completed' => 'Dato odbioru', 'paymentDate' => 'Termin płatności',
        'downloadDate' => 'Transport', 'initialVatPrice' => ' Cena Katalogowa Brutto',
        'initialPriceWithOutVat' => 'Cena Katalogowa Netto', 'priceRoleFive' => 'Cena 1', 'priceRoleSix' => 'Cena 2',
        'priceRoleSeven' => 'Cena 3',
        'brand' => 'Marka', 'model' => 'Model', 'targetUnload' => 'Razladunek',
        'location' => 'Miejsce postoju',
        'versionPolish' => 'wersja', 'versionGerman' => 'Ausführung', 'colorPolish' => 'Kolor', 'colorGerman' => 'Farbe',
        'vendor' => 'Sprzedawca', 'customer' => 'Zamawiający', 'ourDiscountPrice' => 'Cena zakupu Netto',
        'invoiceNumber' => 'Faktura zakupu', 'address1' => 'Adres zaladunka',
        'user' => 'nabyw', 'discount' => 'Rabatt', 'salePriceWithOutVAT' => 'sprz net', 'pay4' => 'pay', 'ekNetto' => 'EK Netto',
        'ekBrutto' => 'EK Brutto', 'ust' => 'USt.', 'datum' => 'Datum', 'seller' => 'Verkäufer', 'carlineDate' => 'Datum',
        'carlineNumber' => 'Bestellnummer', 'gewinn' => 'Gewinn', 'additionalWork' => 'Zusatzarbeiten', 'date' => 'Abholterm.',
        'preisb2b' => 'Preis b2b', 'zahldatum' => 'Zahldatum', 'standtage' => 'Standtage',
        'address3' => 'Adres razladunka', 'zysk' => 'zysk'
    ];

    private const EXCEL_NAME_CELL = [
        1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E', 6 => 'F', 7 => 'G', 8 => 'H',
        9 => 'I', 10 => 'J', 11 => 'K', 12 => 'L', 13 => 'M', 14 => 'N', 15 => 'O', 16 => 'P',
        17 => 'Q', 18 => 'R', 19 => 'S', 20 => 'T', 21 => 'U', 22 => 'V', 23 => 'W', 24 => 'X',
        25 => 'Y', 26 => 'Z', 27 => 'AA', 28 => 'AB', 29 => 'AC', 30 => 'AD', 31 => 'AE', 32 => 'AF',
        33 => 'AG', 34 => 'AH', 35 => 'AI', 36 => 'AJ', 37 => 'AK', 38 => 'AL', 39 => 'AM', 40 => 'AN',
        41 => 'AO', 42 => 'AP', 43 => 'AQ', 44 => 'AR', 45 => 'AS', 46 => 'AT', 47 => 'AU', 48 => 'AV', 49 => 'AW',
        50 => 'AX', 51 => 'AY', 52 => 'AZ', 53 => 'BA', 54 => 'BB',
    ];

    private const EXPORT_STATISTIC_FIELD = [
        'ankauf', 'brand', 'model', 'zustand', 'vinNumber', 'customer', 'ekNetto', 'ekBrutto', 'ust',
        'invoiceNumber', 'paymentDate', 'preisTr', 'datumPayFour', 'orderNumber', 'datum', 'company', 'rechnungsnr',
        'reDatum', 'paymentType', 'zahldatum', 'vkNetto', 'vkBrutto', 'gewinn', 'seller', 'infoStatistic', 'standtage'
    ];

    /**
     * @var string
     */
    private $exportExcelPath;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ExportExcelController constructor.
     *
     * @param string $exportExcelPath
     * @param LoggerInterface $logger
     */
    public function __construct(string $exportExcelPath, LoggerInterface $logger)
    {
        $this->exportExcelPath = $exportExcelPath;
        $this->logger          = $logger;
    }

    /**
     * @Route("")
     * @Template
     *
     * @param Request $request
     *
     * @return array
     */
    public function indexAction(Request $request): array
    {
        $ids = $request->request->get('car-ids');

        $export = new ExportExcelDTO();
        if ($ids !== null) {
            $export->setIds($ids);
        }
        $form = $this
            ->createForm(UserRoleEnum::getExportFormType($this->getUser()->getRole()), $export)
            ->handleRequest($request);

        $fileName = '';
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                [$data, $compPosition] = $this->getData($export);
                $rowCount = \count($data);

                $spreadsheet = new Spreadsheet();
                $spreadsheet->getActiveSheet()
                    ->fromArray(
                        $data,
                    null,
                    'A1'
                );

                $columnsWidth = $this->getColumnWidth($data, $compPosition);
                foreach ($columnsWidth as $value => $column) {
                    $spreadsheet->getActiveSheet()
                        ->getColumnDimension(self::EXCEL_NAME_CELL[$value])->setWidth($column + 3);
                }

                $count = \count($data[0]);
                $lastField = self::EXCEL_NAME_CELL[$count];
                $spreadsheet->getActiveSheet()->getStyle('A1:' . $lastField . '1')
                    ->applyFromArray([
                        'font' => [
                            'bold' => true,
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => [
                                'argb' => 'dedede',
                            ],
                        ]
                    ]);
                $spreadsheet->getActiveSheet()->setAutoFilter('A1:' . $lastField . $rowCount);

                $fileName = uniqid() . '.xlsx';
                $fileSavePath = $this->exportExcelPath . '/' . $fileName;

                $writer = new Xlsx($spreadsheet);
                $writer->save($fileSavePath);
            } catch (\Throwable $exception) {
                $this->logger->error('exportExcel', [
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'message' => $exception->getMessage(),
                ]);
                $fileName = '';
            }
        }

        return ['form' => $form->createView(), 'fileName' => $fileName];
    }

    /**
     * @Route("statistic")
     * @Template
     *
     * @param Request $request
     *
     * @return array
     */
    public function exportStatisticAction(Request $request): array
    {
        $ids = $request->request->get('car-ids');

        $export = new ExportExcelDTO();
        if ($ids !== null) {
            $export->setIds($ids);
        }
        $form = $this
            ->createForm(UserRoleEnum::getExportStatisticFormType($this->getUser()->getRole()), $export)
            ->handleRequest($request);

        $fileName = '';
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                [$data, $compPosition] = $this->getDataForStatistic($export);
                $rowCount = \count($data);

                $spreadsheet = new Spreadsheet();
                $spreadsheet->getActiveSheet()
                    ->fromArray(
                        $data,
                        null,
                        'A1'
                    );

                $columnsWidth = $this->getColumnWidth($data, $compPosition);
                foreach ($columnsWidth as $value => $column) {
                    $spreadsheet->getActiveSheet()
                        ->getColumnDimension(self::EXCEL_NAME_CELL[$value])->setWidth($column + 3);
                }

                $count = \count($data[0]);
                $lastField = self::EXCEL_NAME_CELL[$count];
                $spreadsheet->getActiveSheet()->getStyle('A1:' . $lastField . '1')
                    ->applyFromArray([
                        'font' => [
                            'bold' => true,
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => [
                                'argb' => 'dedede',
                            ],
                        ]
                    ]);
                $spreadsheet->getActiveSheet()->setAutoFilter('A1:' . $lastField . $rowCount);

                $fileName     = uniqid().'.xlsx';
                $fileSavePath = $this->exportExcelPath.'/'.$fileName;

                $writer = new Xlsx($spreadsheet);
                $writer->save($fileSavePath);
            } catch (\Throwable $exception) {
                $this->logger->error('exportExcel', [
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'message' => $exception->getMessage(),
                ]);
                $fileName = '';
            }
        }

        return ['form' => $form->createView(), 'fileName' => $fileName];
    }

    /**
     * @param array $data
     * @param array $compPosition
     *
     * @return array
     */
    private function getColumnWidth(array $data, array $compPosition): array
    {
        $result = [];
        foreach ($compPosition as $position) {
            $result[$position] = 16;
        }
        foreach ($data as $line) {
            foreach ($line as $column => $value) {
                if (!in_array($column + 1, $compPosition)) {
                    $valueLength = mb_strlen($value);
                    $column += 1;
                    if (isset($result[$column])) {
                        if ($result[$column] < $valueLength) {
                            $result[$column] = $valueLength;
                        }
                    } else {
                        $result[$column] = $valueLength;
                    }
                }
            }
        }
        return $result;
    }

    /**
     * @param ExportExcelDTO $export
     *
     * @return array
     */
    private function getData(ExportExcelDTO $export): array
    {
        $result = [];
        $exportFields = [];
        foreach ($export as $key => $value) {
            if ($value === true) {
                $exportFields[] = $key;
            }
        }

        $language = $export->getLanguage();
        $result[] = $this->getHeaderColumnsName($exportFields, $language);

        $em = $this->getDoctrine()->getManager();
        $cars = $em->getRepository(Car::class)->findBy(
            ['id' => explode(',', $export->getIds())],
            ['completed' => 'asc']
        );

        foreach ($cars as $car) {
            $result[] = $this->getCarData($car, $exportFields, $language);
        }

        $compPosition = [];
        $searchFields = ['standartComplectationPolish', 'standartComplectationGerman', 'complectationPolish', 'complectationGerman'];
        foreach ($searchFields as $field) {
            if ($key = array_search($field, $exportFields)) {
                $compPosition[] = $key + 1;
            }
        }
        return [$result, $compPosition];
    }

    /**
     * @param ExportExcelDTO $export
     *
     * @return array
     */
    private function getDataForStatistic(ExportExcelDTO $export): array
    {
        $result       = [];
        $exportTempFields = [];
        foreach ($export as $key => $value) {
            if ($value === true) {
                $exportTempFields[] = $key;
            }
        }
        foreach (self::EXPORT_STATISTIC_FIELD as $field) {
            if (in_array($field, $exportTempFields)) {
                $exportFields[] = $field;
            }
        }

        $language = $export->getLanguage();
        $result[] = $this->getHeaderStatisticColumnsName($exportFields, $language);

        $em   = $this->getDoctrine()->getManager();
        $cars = $em->getRepository(Car::class)->findBy(
            ['id' => explode(',', $export->getIds())],
            ['completed' => 'asc']
        );

        foreach ($cars as $car) {
            $result[] = $this->getCarData($car, $exportFields, $language);
        }

        return [$result, []];
    }

    /**
     * @param array  $exportFields
     * @param string $language
     *
     * @return array
     */
    private function getHeaderStatisticColumnsName(array $exportFields, string $language): array
    {
        $titles = [];
        $translateFields = $language === 'de' ? self::GERMAN_FIELDS : self::POLISH_FIELDS;
        foreach (self::EXPORT_STATISTIC_FIELD as $field) {
            if (in_array($field , $exportFields)) {
                $name = $translateFields[$field];
                if ($field === 'orderNumber') {
                    $name = 'Bestellnummer';
                }
                if ($field === 'datum') {
                    $name = 'Vertragsdatum';
                }
                $titles[] = $name;
            }
        }

        return $titles;
    }

    /**
     * @param array  $exportFields
     * @param string $language
     *
     * @return array
     */
    private function getHeaderColumnsName(array $exportFields, string $language): array
    {
        $titles = [];
        $translateFields = $language === 'de' ? self::GERMAN_FIELDS : self::POLISH_FIELDS;
        foreach ($exportFields as $field) {
            $titles[] = $translateFields[$field];
        }

        return $titles;
    }

    /**
     * @param Car    $car
     * @param array  $fields
     * @param string $language
     *
     * @return array
     */
    private function getCarData(Car $car, array $fields, string $language): array
    {
        $carData = [];
        foreach ($fields as $field) {
            switch (true) {
                case \in_array($field, self::CAR_COLUMNS):
                    $getter = ($field === 'paid' ? 'is' : 'get') . ucfirst($field);
                    if ($field === 'minimumSellingPrice') {
                        if ($car->$getter() === null) {
                            $carData[] = '';
                        } else {
                            $carData[] = $car->$getter();
                        }
                    } elseif ($field === 'paid') {
                        $carData[] = $car->$getter() === true ? 'x' : '';
                    } else {
                        $carData[] = $car->$getter();
                    }
                    break;
                case \in_array($field, self::CAR_COLUMNS_DATE):
                    $getter = 'get' . ucfirst($field);
                    $carData[] = $car->$getter() === null ? null : $car->$getter()->format('d.m.Y');
                    break;
                case \in_array($field, self::CAR_COLUMNS_PRICE):
                    $getter = 'get' . ucfirst($field);
                    $carData[] = $car->$getter() === null
                        ? null
                        : $car->$getter();
                    break;
                case \in_array($field, self::CAR_JOINED):
                    $getter     = 'get'.ucfirst($field);
                    $carData[] = $car->$getter() === null ? null : $car->$getter()->getTitle();
                    break;
                case $field === 'versionPolish' || $field === 'versionGerman':
                    $getter = 'get' . ucfirst($field);
                    $versionGetter = $field === 'versionPolish' ? 'getPolish' : 'getGerman';
                    $carData[] = $car->$getter() === null ? null : $car->$getter()->$versionGetter();
                    break;
                case $field === 'colorPolish' || $field === 'colorGerman':
                    $getter = 'get' . ucfirst($field);
                    $colorGetter = $field === 'colorPolish' ? 'getPolish' : 'getGerman';
                    $carData[] = $car->$getter() === null ? null : $car->$getter()->$colorGetter();
                    break;
                case $field === 'carCondition':
                    $getter = 'get' . ucfirst($field);
                    $value = $car->$getter();
                    if ($value === CarConditionEnum::SOLD) {
                        $value = $language === 'de' ? 'Verkauft' : 'Sprzedane';
                    } elseif ($value === CarConditionEnum::RESERVATION) {
                        $value = $language === 'de' ? 'Reserviert' : 'Rezerwacja';
                    }
                    $carData[] = $value;
                    break;
                case $field === 'address1':
                    $value = $car->getVendor() !== null ? $car->getVendor()->getAddress() : '';
                    $carData[] = $value;
                    break;
                case $field === 'user':
                    $user      = $car->getUser();
                    $value     = $user !== null ? $user->getFullName() : '';
                    $carData[] = $value;
                    break;
                case $field === 'discount':
                    $value     = round($car->getDiscount(), 1) <= 0 ? '' : round($car->getDiscount(), 1);
                    $carData[] = $value;
                    break;
                case $field === 'pay4':
                    $value     = $car->isPay4() === true ? 'x' : '';
                    $carData[] = $value;
                    break;
                case $field === 'seller':
                    $seller    = $car->getSeller();
                    $value     = $seller !== null ? $seller->getFullName() : '';
                    $carData[] = $value;
                    break;
                case $field === 'preisb2b':
                    $carData[] = $car->getPriceByShowPrice();
                    break;
                case $field === 'zustand':
                    if ($car->getCarMileage() === null || $car->getCarMileage() === '') {
                        $zustand = 'Neu';
                    } else {
                        $zustand = 'Gebraucht';
                    }
                    $carData[] = $zustand;
                    break;
                case $field === 'company':
                    if ($car->getFirma() !== null && $car->getFirma() !== '') {
                        $client = $car->getFirma();
                    } else {
                        $client = $car->getLastName() !== null ? $car->getLastName() : '';
                    }
                    $carData[] = $client;
                    break;
                case $field === 'vkNetto':
                    $vkNetto  = null;
                    $taxType  = $car->getTaxType() !== null ? $car->getTaxType()->getTitle() : null;
                    if (
                        $taxType == 'umsatzsteuerfrei nach §4 Nr.1a UStG (Export außerhalb der EU)' ||
                        $taxType == 'umsatzsteuerfrei nach §4 Nr.1b UStG (Export innerhalb der EU)'
                    ) {
                        $vkNetto = $car->getSellingPrice() !== null ? $car->getSellingPrice() : null;
                    }

                    $carData[] = $vkNetto;
                    break;
                case $field === 'vkBrutto':
                    $vkBrutto = null;
                    $taxType  = $car->getTaxType() !== null ? $car->getTaxType()->getTitle() : null;
                    if (
                        $taxType != 'umsatzsteuerfrei nach §4 Nr.1a UStG (Export außerhalb der EU)' ||
                        $taxType != 'umsatzsteuerfrei nach §4 Nr.1b UStG (Export innerhalb der EU)'
                    ) {
                        $vkBrutto = $car->getSellingPrice() !== null ? $car->getSellingPrice() : null;
                    }
                    $carData[] = $vkBrutto;
                    break;
                case $field === 'rechnungsnr':
                    $carData[] = '';
                    break;
                case $field === 'reDatum':
                    $carData[] = '';
                    break;
                case $field === 'standtage':
                    $standtage = '';
                    if ($car->getAnkauf() !== null && $car->getDatum() !== null) {
                        $standtage = date_diff($car->getAnkauf(), $car->getDatum())->days;
                    }
                    $carData[] = $standtage;
                    break;
                case $field === 'address3':
                    $kaufer       = $car->getUser();
                    $targetUnload = $car->getTargetUnload();
                    $carCondition = $car->getCarCondition();
                    $value        = '';

                    if (
                        $kaufer !== null
                        && $targetUnload !== null
                        && !in_array($kaufer->getFirmNumber(), ['Lichtblick GmbH', 'Carpoint GmbH'])
                        && $targetUnload->getTitle() === 'Klient'
                        && $carCondition === CarConditionEnum::SOLD
                    ) {
                        $value = $this->getBuyerAddress($kaufer);
                    } elseif (
                        $kaufer !== null
                        && $targetUnload !== null
                        && $targetUnload->getTitle() === 'Klient'
                        && in_array($kaufer->getFirmNumber(), ['Carpoint GmbH'])
                    ) {
                        $value = $this->getCarKlientAddress($car);
                    } elseif (
                        $kaufer !== null
                        && $targetUnload !== null
                        && ($attachKaufer = $targetUnload->getUser()) !== null
                        && in_array($kaufer->getFirmNumber(), ['Lichtblick GmbH', 'Carpoint GmbH'])
                        && $carCondition === CarConditionEnum::SOLD
                    ) {
                        $value = $this->getBuyerAddress($attachKaufer);
                    }

                    $carData[] = $value;
                    break;
            }
        }
        return $carData;
    }

    /**
     * @param User $user
     *
     * @return string
     */
    private function getBuyerAddress(User $user): string
    {
        $result = '';
        $getters = ['getFirmNumber', 'getStreet', 'getPlaceIndex', 'getCity', 'getPhoneNumber'];

        foreach ($getters as $getter) {
            $value  = $user->$getter();
            $result = $result === '' ? $value : $result.', '.$value;
        }

        return $result;
    }

    /**
     * @param Car $car
     *
     * @return mixed|string
     */
    private function getCarKlientAddress($car)
    {
        $result  = '';
        $getters = ['getFirma', 'getFirstName', 'getStreet', 'getCity', 'getPlaceIndex'];

        foreach ($getters as $getter) {
            $value = $getter === 'getFirstName'
                ? $car->$getter().' '.$car->getLastName()
                : $car->$getter();
            $result = $result === '' || $result === null ? $value : $result.', '.$value;
        }

        return $result;
    }
}