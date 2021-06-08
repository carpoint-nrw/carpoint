<?php

namespace AdminBundle\Services;

use AdminBundle\Entity\Car;
use AdminBundle\Entity\CarEditHistory;
use AdminBundle\Entity\User\Admin;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class CarUpdater
 *
 * @package AdminBundle\Services
 */
class CarUpdater
{
    private const FIELDS_TRANSLATE = [
        'gewinn' => ['polish' => 'Gewinn', 'german' => 'Gewinn'],
        'carInvoiceNumberYear' => ['polish' => 'Jahr', 'german' => 'Jahr'],
        'registrationCertificateDescription' => ['polish' => 'Zusatz zur Bescheinigung', 'german' => 'Zusatz zur Bescheinigung'],
        'firmNumber' => ['polish' => 'Ust-ID-Nummer', 'german' => 'Ust-ID-Nummer'],
        'registrationCertificate' => ['polish' => 'Zulassungsbescheinigung', 'german' => 'Zulassungsbescheinigung'],
        'datum' => ['polish' => 'Datum', 'german' => 'Datum'],
        'ort' => ['polish' => 'Ort', 'german' => 'Ort'],
        'ptsNumber' => ['polish' => 'Briefnr.', 'german' => 'Briefnr.'],
        'fuel' => ['polish' => 'Kraftstoff', 'german' => 'Kraftstoff'],
        'carStatus' => ['polish' => 'Fhrgstatus', 'german' => 'Fhrgstatus'],
        'bodyType' => ['polish' => 'Fahrzg Art', 'german' => 'Fahrzg Art'],
        'proformaDate' => ['polish' => 'Proforma-Datum', 'german' => 'Proforma-Datum'],
        'proformaNumber' => ['polish' => 'Proforma-Nr.', 'german' => 'Proforma-Nr.'],
        'clientStatus' => ['polish' => 'Käuferstus', 'german' => 'Käuferstus'],
        'fax' => ['polish' => 'Fax', 'german' => 'Fax'],
        'mobileNumber' => ['polish' => 'mobil', 'german' => 'mobil'],
        'phoneNumber' => ['polish' => 'Tel.', 'german' => 'Tel.'],
        'email' => ['polish' => 'Email', 'german' => 'Email'],
        'carInvoiceDate' => ['polish' => 'Rechn-datum', 'german' => 'Rechn-datum'],
        'carInvoiceNumber' => ['polish' => 'Rechn-nummer', 'german' => 'Rechn-nummer'],
        'placeIndex' => ['polish' => 'placeIndex', 'german' => 'placeIndex'],
        'city' => ['polish' => 'Stadt', 'german' => 'Stadt'],
        'street' => ['polish' => 'Strasse', 'german' => 'Strasse'],
        'lastName' => ['polish' => 'Nachname', 'german' => 'Nachname'],
        'firstName' => ['polish' => 'Vorname', 'german' => 'Vorname'],
        'firma' => ['polish' => 'Firma', 'german' => 'Firma'],
        'zahldatum' => ['polish' => 'Datum', 'german' => 'Datum'],
        'zahldatumPay' => ['polish' => 'Pay', 'german' => 'Pay'],
        'paymentCondition' => ['polish' => 'Zahlungsbediengungen', 'german' => 'Zahlungsbediengungen'],
        'paymentType' => ['polish' => 'Zahlungsart', 'german' => 'Zahlungsart'],
        'restsumme' => ['polish' => 'Restsumme', 'german' => 'Restsumme'],
        'deposit' => ['polish' => 'Anzahlung', 'german' => 'Anzahlung'],
        'taxType' => ['polish' => 'Umsatzsteuer', 'german' => 'Umsatzsteuer'],
        'pay5' => ['polish' => 'bezahlt', 'german' => 'bezahlt'],
        'preisTr' => ['polish' => 'Transport', 'german' => 'Transport'],
        'ankauf' => ['polish' => 'Ankauf', 'german' => 'Ankauf'],
        'ust' => ['polish' => 'USt.', 'german' => 'USt.'],
        'mwst' => ['polish' => 'Mwst', 'german' => 'Mwst'],
        'ekBrutto' => ['polish' => 'EK Brutto', 'german' => 'EK Brutto'],
        'ekNetto' => ['polish' => 'EK Netto', 'german' => 'EK Netto'],
        'carlineNumber' => ['polish' => 'Bestellnummer', 'german' => 'Bestellnummer'],
        'carlineDate' => ['polish' => 'Datum', 'german' => 'Datum'],
        'info' => ['polish' => 'info', 'german' => 'info'],
        'segregator' => ['polish' => 'segregator', 'german' => 'segregator'],
        'zysk' => ['polish' => 'zysk', 'german' => 'Gewinn'],
        'paidSuccess' => ['polish' => 'zaplacona', 'german' => 'bezahlt'],
        'dataFv2' => ['polish' => 'data fv', 'german' => 'Rchg Datum'],
        'dataPro2' => ['polish' => 'data pro', 'german' => 'Datum pro'],
        'nrPro2' => ['polish' => 'nomer pro', 'german' => 'Nummer pro'],
        'salePriceWithVATType' => ['polish' => 'PLN/EUR', 'german' => 'PLN/EUR'],
        'salePriceWithVAT' => ['polish' => 'cena brutt', 'german' => 'Preis Brutto'],
        'salePriceWithOutVATType' => ['polish' => 'PLN/EUR', 'german' => 'PLN/EUR'],
        'data2' => ['polish' => 'data platn', 'german' => 'Zahldatum'],
        'pay' => ['polish' => 'zaplacone', 'german' => 'bezahlt'],
        'shippingCostType' => ['polish' => 'PLN/EUR', 'german' => 'PLN/EUR'],
        'showPrice' => ['polish' => 'Preis', 'german' => 'Preis'],
        'dataFv' => ['polish' => 'data fv', 'german' => 'Rchg Datum'],
        'nrFv' => ['polish' => 'nomer fv', 'german' => 'Rechngnr.'],
        'data1' => ['polish' => 'data zapl', 'german' => 'Zahldatum'],
        'pay4' => ['polish' => 'zaplacona', 'german' => 'zaplacona'],
        'dataPro' => ['polish' => 'data prof', 'german' => 'Datum pro'],
        'nrPro' => ['polish' => 'nomer prof', 'german' => 'Nummer pro'],
        'vat' => ['polish' => 'vat', 'german' => 'Umsatzst.'],
        'zakupBrut' => ['polish' => 'zakup brut', 'german' => 'EK Brut.'],
        'demo' => ['polish' => 'Demo', 'german' => 'Demo'],
        'fhnr' => ['polish' => 'mobile.de', 'german' => 'Fahrzeugnr'],
        'versionGerman' => ['polish' => 'Ausführung', 'german' => 'Ausführung'],
        'versionPolish' => ['polish' => 'wersia', 'german' => 'wersia'],
        'carVisibility' => ['polish' => 'Carpoint', 'german' => 'Carline'],
        'standartComplectationGerman' => ['polish' => 'specyfikacje', 'german' => 'Serienausstattung'],
        'standartComplectationPolish' => ['polish' => 'specyfikacje', 'german' => 'Serienausstattung'],
        'datumPayFour' => ['polish' => 'Datum', 'german' => 'Datum'],

        'vendor' => ['polish' => 'Sprzedawca', 'german' => 'Lieferant'],
        'place' => ['polish' => 'Adres załadunku', 'german' => 'Platz'],
        'customer' => ['polish' => 'Zamawiający', 'german' => 'Besteller'],
        'carCondition' => ['polish' => 'rez/sprz', 'german' => 'RS/VK'],
        'vinNumber' => ['polish' => 'VIN', 'german' => 'Fahrgnr.'],
        'brand' => ['polish' => 'Marka', 'german' => 'Marke'],
        'model' => ['polish' => 'Model', 'german' => 'Model'],
        'colorPolish' => ['polish' => 'Kolor', 'german' => 'Kolor'],
        'colorGerman' => ['polish' => 'Farbe', 'german' => 'Farbe'],
        'complectationPolish' => ['polish' => 'Opcje', 'german' => 'Opcje'],
        'complectationGerman' => ['polish' => 'Sonderausstattung', 'german' => 'Sonderausstattung'],
        'carRegistration' => ['polish' => 'data rejtr', 'german' => 'EZ'],
        'carMileage' => ['polish' => 'przybieg', 'german' => 'Km'],
        'initialVatPrice' => ['polish' => 'kat brutto', 'german' => 'Liste Brut'],
        'initialPriceWithOutVat' => ['polish' => 'kat netto', 'german' => 'Liste Net'],
        'ourDiscountPrice' => ['polish' => 'zakup net', 'german' => 'EK Net.'],
        'discount' => ['polish' => 'rabatt', 'german' => 'Rabatt'],
        'priceRoleFive' => ['polish' => 'cena 1', 'german' => 'Preis 1'],
        'priceRoleSix' => ['polish' => 'cena 2', 'german' => 'Preis 2'],
        'priceRoleSeven' => ['polish' => 'cena 3', 'german' => 'Preis 3'],
        'completed' => ['polish' => 'otbior dat', 'german' => 'Abholterm.'],
        'invoiceNumber' => ['polish' => 'nr fv', 'german' => 'Rechnungs nr.'],
        'paymentDate' => ['polish' => 'data fv', 'german' => 'Rchg Datum'],
        'paid' => ['polish' => 'zaplacone', 'german' => 'Bezahlt'],
        'documents' => ['polish' => 'dokumenty', 'german' => 'Papiere'],
        'downloadDate' => ['polish' => 'trans data', 'german' => 'Trans Dat.'],
        'targetUnload' => ['polish' => 'razladunek', 'german' => 'Lieferort'],
        'forwarder' => ['polish' => 'trans firm', 'german' => 'Trans Fa.'],
        'shippingCost' => ['polish' => 'cena trans', 'german' => 'Transport'],
        'transportInvoiceNumber' => ['polish' => 'trans fv', 'german' => 'Trans Rech'],
        'location' => ['polish' => 'postoju', 'german' => 'Standort'],
        'orderNumber' => ['polish' => 'nr. zamow', 'german' => 'Bestellung'],
        'radioCode' => ['polish' => 'radiokod', 'german' => 'Radiocode'],
        'user' => ['polish' => 'nabywca', 'german' => 'Käufer'],
        'salePriceWithOutVAT' => ['polish' => 'cena netto', 'german' => 'Preis Nett'],
        'salesInvoiceNumber' => ['polish' => 'nr fv', 'german' => 'Rechnungnr'],
        'invoiceDate' => ['polish' => 'data zapl', 'german' => 'Zahldatum'],
        'information' => ['polish' => 'info', 'german' => 'info'],
        'discharge' => ['polish' => 'Beslellnr.', 'german' => 'Beslellnr.'],
        'sellingPrice' => ['polish' => 'Kaufpreis', 'german' => 'Kaufpreis'],
        'seller' => ['polish' => 'Verkäufer', 'german' => 'Verkäufer'],
        'additionalWork' => ['polish' => 'Zusatzarbeiten', 'german' => 'Zusatzarbeiten'],
        'notes' => ['polish' => 'Notizen', 'german' => 'Notizen'],
        'date' => ['polish' => 'Abholterm.', 'german' => 'Abholterm.'],
        'placeOfIssue' => ['polish' => 'Ausliefort', 'german' => 'Ausliefort'],
        'importTax' => ['polish' => 'akzysa', 'german' => 'Akzysa'],
        'taxNumber' => ['polish' => 'akzysa nr', 'german' => 'Akzysa nr.'],
        'taxReturned' => ['polish' => 'Akcyza zakończony', 'german' => 'Akcyza erledigt'],
    ];

    private const FIELDS_TYPE_REFERENCES = [
        'brand', 'customer', 'forwarder', 'location', 'model', 'place', 'clientStatus', 'paymentType', 'taxType',
        'targetUnload', 'vendor', 'fuel', 'carStatus', 'bodyType', 'paymentCondition', 'ort', 'location'
    ];

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * CarUpdater constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Admin                  $admin
     * @param Car                    $car
     * @param EntityManagerInterface $em
     *
     * @return void
     */
    public function checkCarUpdate(Admin $admin, Car $car, EntityManagerInterface $em): void
    {
        try {
            $uow = $em->getUnitOfWork();
            $uow->computeChangeSets();
            $changeset = $uow->getEntityChangeSet($car);

            $date = new \DateTime();
            foreach ($changeset as $key => $value) {
                $cOldValue = $value[0];
                $cNewValue = $value[1];

                if (in_array($key, self::FIELDS_TYPE_REFERENCES)) {
                    $oldValue = $cOldValue === null ? null : $cOldValue->getTitle();
                    $newValue = $cNewValue === null ? null : $cNewValue->getTitle();
                } elseif ($cOldValue instanceof \DateTime || $cNewValue instanceof \DateTime) {
                    $oldValue = $cOldValue === null ? null : $cOldValue->format('d.m.Y');
                    $newValue = $cNewValue === null ? null : $cNewValue->format('d.m.Y');
                } elseif (in_array($key, ['versionGerman', 'colorGerman'])) {
                    $oldValue = $cOldValue === null ? null : $cOldValue->getGerman();
                    $newValue = $cNewValue === null ? null : $cNewValue->getGerman();
                } elseif (in_array($key, ['versionPolish', 'colorPolish'])) {
                    $oldValue = $cOldValue === null ? null : $cOldValue->getPolish();
                    $newValue = $cNewValue === null ? null : $cNewValue->getPolish();
                } elseif (in_array($key, [
                    'standartComplectationPolish', 'standartComplectationGerman',
                    'dateOfBooking', 'payClick',
                ])) {
                    continue;
                } elseif (in_array($key, ['user', 'seller'])) {
                    $oldValue = $cOldValue === null ? null : $cOldValue->getFullName();
                    $newValue = $cNewValue === null ? null : $cNewValue->getFullName();
                } else {
                    $oldValue = $cOldValue === null ? null : $cOldValue;
                    $newValue = $cNewValue === null ? null : $cNewValue;
                }

                if (is_bool($newValue)) {
                    $newValue = $newValue ? 'true' : 'false';
                }

                if (is_bool($oldValue)) {
                    $oldValue = $oldValue ? 'true' : 'false';
                }

                if (!is_string($newValue) && $newValue !== null) {
                    $newValue = (string) $newValue;
                }

                if (!is_string($oldValue) && $oldValue !== null) {
                    $oldValue = (string) $oldValue;
                }

                if (is_string($oldValue) && strlen($oldValue) > 250) {
                    $oldValue = substr($oldValue, 0, 250);
                }
                if (is_string($newValue) && strlen($newValue) > 250) {
                    $newValue = substr($newValue, 0, 250);
                }

                if (!is_string($newValue) && $newValue !== null) {
                    continue;
                }

                if (!is_string($oldValue) && $oldValue !== null) {
                    continue;
                }

                $carEditHistory = (new CarEditHistory())
                    ->setAdmin($admin)
                    ->setCar($car)
                    ->setEditDate($date)
                    ->setColumnGerman(self::FIELDS_TRANSLATE[$key]['german'] ?? null)
                    ->setColumnPolish(self::FIELDS_TRANSLATE[$key]['polish'] ?? null)
                    ->setOldValue($oldValue)
                    ->setNewValue($newValue);

                $em->persist($carEditHistory);
            }
        } catch (\Throwable $exception) {
            $this->logger->error('car-update', [
                'line'    => $exception->getLine(),
                'message' => $exception->getMessage(),
            ]);
        }
    }
}