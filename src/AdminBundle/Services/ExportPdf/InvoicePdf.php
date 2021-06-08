<?php

namespace AdminBundle\Services\ExportPdf;

use AdminBundle\Entity\Car;
use AdminBundle\Entity\References\Color;

/**
 * Class InvoicePdf
 *
 * @package AdminBundle\Services\ExportPdf
 */
class InvoicePdf extends AbstractExportPdf
{
    private const CAR_DATA = [
        'Marke'             => 'getBrand',
        'Modell'            => 'getModel',
        'Fahrzeugart'       => 'getBodyType',
        'Kraftstoffart'     => 'getFuel',
        'Außenfarbe'        => 'getColorGerman',
        'Fahrgestellnummer' => 'getVinNumber',
        'Erstzulassung'     => 'getCarRegistration',
    ];

    private const TOP_LEFT_DATA = '<td class="font-size-11">{value}</td>';

    private const TOP_RIGHT_DATA = [
        'carInvoiceNumber' => '<td class="right-text font-size-11"><span class="bold-text">Rechnungsnummer:</span> {carInvoiceNumber}</td>',
        'carInvoiceDate'   => '<td class="right-text font-size-11"><span class="bold-text">Rechnungsdatum:</span> {carInvoiceDate}</td>',
        'date'             => '<td class="right-text font-size-11"><span class="bold-text">Auslieferungsdatum:</span> {date}</td>',
    ];

    private const TOP_DATA = [
        ['left' => null, 'right' => null],
        ['left' => null, 'right' => null],
        ['left' => null, 'right' => null],
        ['left' => null, 'right' => null],
        ['left' => null, 'right' => null],
        ['left' => null, 'right' => null],
        ['left' => null, 'right' => null],
        ['left' => null, 'right' => null],
        ['left' => null, 'right' => null],
    ];

    /**
     * @var Car
     */
    private $car;

    /**
     * {@inheritdoc}
     */
    public function _destroy($destroyall = false, $preserve_objcopy = false)
    {
        if ($destroyall) {
            unset($this->imagekeys);
        }

        parent::_destroy($destroyall, $preserve_objcopy);
    }

    /**
     * {@inheritdoc}
     */
    public function Footer() {
        $footer = '
            <style>
                .center-text {
                    text-align: center;
                }
                .foote-font-size {
                    font-size: 9px;
                }
                .dark-blue {
                    color: #040452;
                }
            </style>
            <table class="foote-font-size">
                <tr>
                    <td colspan="2">___________________________________________________________________________________________________________</td>
                </tr>
                <tr>
                    <td class="center-text dark-blue" colspan="2">CARPOINT GmbH   *   Geschäftsführerin Marina Jung   *   Weserstraße 3   *   47506 Neukirchen-Vluyn</td>
                </tr>
                <tr>
                    <td class="center-text dark-blue" colspan="2">Bankverbindung : Volksbank Niederrhein IBAN: DE33 3546 1106 8019 4370 10 BIC: GEN0DED1NRH</td>
                </tr>
                <tr>
                    <td class="center-text dark-blue" colspan="2">Ust. ID Nummer: DE 285 943 871 * Steuer Nr: 119 / 5770 / 0220 *  AG Kleve HRB 11696</td>
                </tr>
            </table>
        ';

        $this->SetY(-20);
        $this->writeHTML($footer, true, false, true, false, '');
    }

    /**
     * @param Car   $car
     * @param array $params
     *
     * @return void
     */
    public function export(Car $car, array $params): void
    {
        $this->car = $car;
        $fileName  = $params['fileName'] ?? null;
        $filePath  = $params['filePath'] ?? null;

        $this->SetPrintHeader(false);
        $this->SetMargins(10, 12, 10);
        $this->SetFont('times');

        $this->AddPage();
        $firstPage = $this->getFirstPage();
        $this->writeHTML($firstPage, true, false, true, false, '');

        $this->Output($filePath.'/'.$fileName, 'F'); // I - browser, D - download, F - save
        $this->Output($fileName, 'I'); // I - browser, D - download, F - save
    }

    /**
     * @return string
     */
    private function getFirstPage(): string
    {
        $html = '';
        $html .= $this->getStyles();
        $html .= $this->initTable();
        $html .= $this->getHeaderInfo();
        $html .= $this->getFirstPageBody();
        $html .= $this->closeTable();

        return $html;
    }

    /**
     * @return string
     */
    private function getStyles(): string
    {
        return '
            <style>
                .carpoint-image {
                    width: 150px;
                }
                .bold-text {
                    font-weight: bold;
                }
                .center-text {
                    text-align: center;
                }
                .right-text {
                    text-align: right;
                }
                .font-size-15 {
                    font-size: 15px;
                }
                .justify-text {
                    text-align: justify;
                }
                .font-size-doc {
                    font-size: 10px;
                }
                .font-size-12 {
                    font-size: 12px;
                }
                .font-size-11 {
                    font-size: 11px;
                }
                .font-size-9 {
                    font-size: 9px;
                }
                .dark-blue {
                    color: #040452;
                }
            </style>
        ';
    }

    /**
     * @param bool $nobr
     *
     * @return string
     */
    private function initTable($nobr = false): string
    {
        $openTable = '<table class="justify-text font-size-doc"{options}>';
        $options   = $nobr ? ' nobr="true"' : '';
        $openTable = str_replace('{options}', $options, $openTable);

        return $openTable;
    }

    /**
     * @return string
     */
    private function closeTable(): string
    {
        return '</table>';
    }

    /**
     * @param boolean $left
     *
     * @return string
     */
    private function getHeaderInfo(bool $left = true)
    {
        $html = '
            <tr>
                <td></td>
                <td class="right-text"><img src="files/carpoint.jpg" alt="" class="carpoint-image"></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td class="right-text">Karosserie- und Fahrzeugbetrieb</td>
            </tr>
            <tr>
                <td></td>
                <td class="right-text">Reparatur und Einbau von Autoglas</td>
            </tr>
            <tr>
                <td></td>
                <td class="right-text">Telefon:  +49 (0)2845  98 46 735</td>
            </tr>
            <tr>
                <td></td>
                <td class="right-text">Fax:  +49 (0)2845  98 46 737</td>
            </tr>
            <tr>
                <td></td>
                <td class="right-text">www.carpoint-nrw.de</td>
            </tr>
            <tr>
                <td class="font-size-9">{carpoint}</td>
                <td class="right-text">info@carpoint-nrw.de</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
        ';

        $carpoint = $left ? 'CARPOINT GmbH * Weserstr. 3 * 47506 Neukirchen-Vluyn' : '';
        $html     = str_replace('{carpoint}', $carpoint, $html);

        $data = [];
        if ($this->car->getFirma() !== null && $this->car->getFirma() !== '') {
            $data[] = $this->car->getFirma() !== null ? $this->car->getFirma() : null;
        }
        if ($this->car->getFirstName() !== null && $this->car->getLastName() !== null) {
            $data[] = $this->car->getFirstName() . ' ' . $this->car->getLastName();
        }
        $data[] = $this->car->getStreet() ?? null;
        $data[] = $this->car->getPlaceIndex() !== null && $this->car->getCity() !== null ? $this->car->getPlaceIndex() . ' ' . $this->car->getCity() : null;
        $data[] = $this->car->getEmail() ?? null;
        $data[] = $this->car->getFirmNumber() ?? null;

        $data = array_filter($data, function($element) {
            return $element !== null;
        });

        $topLeftData = [];
        foreach ($data as $elem) {
            $topLeftData[] = str_replace('{value}', $elem, self::TOP_LEFT_DATA);
        }

        $topRightData  = [];
        $invoiceNumber = $this->car->getCarInvoiceNumber();
        if ($invoiceNumber !== null) {
            $invoiceNumber  = str_pad($invoiceNumber, 4, 0, STR_PAD_LEFT);
            $invoiceYear    = $this->car->getCarInvoiceNumberYear();
            $topRightData[] = str_replace('{carInvoiceNumber}', $invoiceYear.'-'.$invoiceNumber, self::TOP_RIGHT_DATA['carInvoiceNumber']);
        }
        $invoiceDate = $this->car->getCarInvoiceDate() !== null ? $this->car->getCarInvoiceDate()->format('d.m.y') : null;
        if ($invoiceDate !== null) {
            $topRightData[] = str_replace('{carInvoiceDate}', $invoiceDate, self::TOP_RIGHT_DATA['carInvoiceDate']);
        }
        $date = $this->car->getDate() !== null ? $this->car->getDate()->format('d.m.y') : null;
        if ($date !== null) {
            $topRightData[] = str_replace('{date}', $date, self::TOP_RIGHT_DATA['date']);
        }

        $resultData = [];
        foreach (self::TOP_DATA as $line) {
            $leftValue     = array_shift($topLeftData);
            $line['left']  = $leftValue;

            $rightValue    = array_shift($topRightData);
            $line['right'] = $rightValue;

            $resultData[] = $line;
        }

        foreach ($resultData as $resultLine) {
            if ($resultLine['left'] === null && $resultLine['right'] === null) {
                continue;
            }
            $lineStart = '<tr>';
            $lineEnd   = '</tr>';

            $leftData  = $resultLine['left'] === null || $left === false ? '<td></td>' : $resultLine['left'];
            $rightData = $resultLine['right'] === null ? '<td></td>' : $resultLine['right'];

            $resultLineData = $lineStart.$leftData.$rightData.$lineEnd;
            $html .= $resultLineData;
        }

        $html .= '
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
        ';

        return $html;
    }

    /**
     * @return string
     */
    private function getFirstPageBody(): string
    {
        $html = '
            <tr>
                <td colspan="2" class="center-text font-size-15 bold-text dark-blue">Rechnung</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2">Wir bedanken uns recht herzlich für Ihren Auftrag und berechnen Ihnen folgende Leistungen</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="bold-text font-size-12">Angaben zum Fahrzeug</td>
                <td></td>
            </tr>
        ';

        $tr = '
            <tr class="font-size-11">
                <td>{name}</td>
                <td class="right-text">{value}</td>
            </tr>
        ';
        foreach (self::CAR_DATA as $name => $getter) {
            $data = $this->car->$getter();

            if ($getter === 'getBodyType') {
                $resultValue  = $this->car->getBodyType() !== null ? $this->car->getBodyType() : '';
                $delimeter    = $resultValue === '' ? '' : ' ';
                $resultValue .= $delimeter.($this->car->getCarStatus() !== null ? $this->car->getCarStatus() : '');

                if ($resultValue !== '') {
                    $row = $tr;
                    $row = str_replace(['{name}', '{value}'], [$name, $resultValue], $row);
                    $html .= $row;
                }
                continue;
            }

            if ($data instanceof Color) {
                if ($data->getGerman() !== null) {
                    $row = $tr;
                    $row = str_replace(['{name}', '{value}'], [$name, $data->getGerman()], $row);
                    $html .= $row;
                }
                continue;
            }
            if (is_object($data) && !$data instanceof \DateTime) {
                if ($getter === 'getModel') {
                    if ($data->getTitle() !== null) {
                        $row = $tr;
                        $modeAndVersion = $data->getTitle().' '.($this->car->getVersionGerman() !== null ? $this->car->getVersionGerman()->getGerman() : '');
                        $row = str_replace(['{name}', '{value}'], [$name, $modeAndVersion], $row);
                        $html .= $row;
                    }
                    continue;
                }

                if ($data->getTitle() !== null) {
                    $row = $tr;
                    $row = str_replace(['{name}', '{value}'], [$name, $data->getTitle()], $row);
                    $html .= $row;
                }
                continue;
            }
            if ($data instanceof \DateTime) {
                $row = $tr;
                $row = str_replace(['{name}', '{value}'], [$name, $data->format('d.m.y')], $row);
                $html .= $row;
                continue;
            }
            if (is_string($data)) {
                $row = $tr;
                $row = str_replace(['{name}', '{value}'], [$name, $data], $row);
                $html .= $row;
                continue;
            }
        }

        $paymentType = $this->car->getPaymentType() !== null ? $this->car->getPaymentType()->getTitle() : null;
        if ($paymentType !== null) {
            $row = '
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Zahlungsart:</td>
                    <td class="right-text">{paymentType}</td>
                </tr>
            ';

            $zahldatum = $this->car->getZahldatum() !== null ? $this->car->getZahldatum()->format('d.m.Y') : null;
            if ($zahldatum !== null) {
                $paymentType .= ', '.$zahldatum;
            }

            $row = str_replace('{paymentType}', $paymentType, $row);
            $html .= $row;
        }

        $taxType      = $this->car->getTaxType();
        $sellingPrice = $this->car->getSellingPrice();
        if ($taxType !== null && $sellingPrice !== null) {
            $tax = $taxType->getTax() ?? null;

            $price1 = $sellingPrice;
            $price2 = 0;
            $price3 = $sellingPrice;

            if ($tax !== null) {
                $tax    = '1.'.$tax;
                $price1 = round($sellingPrice / (float) $tax, 2);
                $price2 = round($sellingPrice - $price1, 2);
            }

            $price1 = number_format($price1, 2, ',', '.') . ' €';
            $price2 = number_format($price2, 2, ',', '.') . ' €';
            $price3 = number_format($price3, 2, ',', '.') . ' €';

            $text1 = $taxType->getWithOutTaxText();
            $text2 = $taxType->getTaxValueText();
            $text3 = $taxType->getFullPriceText();

            $row = '';
            $row .= '
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="font-size-12">
                    <td style="width: 70%">{text1}</td>
                    <td style="width: 30%" class="right-text">{price1}</td>
                </tr>
                <tr class="font-size-12">
                    <td style="width: 70%">{text2}</td>
                    <td style="width: 30%" class="right-text">{price2}</td>
                </tr>
                <tr class="font-size-12">
                    <td style="width: 70%">{text3}</td>
                    <td style="width: 30%" class="right-text">{price3}</td>
                </tr>
            ';

            $row = str_replace(
                ['{text1}', '{text2}', '{text3}', '{price1}', '{price2}', '{price3}'],
                [$text1, $text2, $text3, $price1, $price2, $price3],
                $row
            );
            $html .= $row;
        }

        return $html;
    }
}