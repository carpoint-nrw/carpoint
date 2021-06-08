<?php

namespace AdminBundle\Services\ExportPdf;

use AdminBundle\Entity\Car;
use AdminBundle\Entity\References\AbstractReferences;
use AdminBundle\Entity\References\Color;
use AdminBundle\Entity\References\Version;
use Symfony\Component\HttpFoundation\Response;
use TCPDF;

/**
 * Class DeedPdf
 *
 * @package AdminBundle\Services\ExportPdf
 */
class DeedPdf extends AbstractExportPdf
{
    private const CAR_DATA = [
        'Marke'             => 'getBrand',
        'Modell'            => 'getModel',
        'Fahrzeugart'       => 'getBodyType',
        'Kraftstoffart'     => 'getFuel',
        'Außenfarbe'        => 'getColorGerman',
        'Fahrgestellnummer' => 'getVinNumber',
        'Erstzulassung'     => 'getCarRegistration',
        'Laufleistung'      => 'getCarMileage',
        'Radio Code'        => 'getRadioCode',
    ];

    private const TOP_LEFT_DATA = '<td class="font-size-11">{value}</td>';

    private const TOP_RIGHT_DATA = [
        'sellerName'   => '<td class="right-text font-size-11"><span class="bold-text">Ihr/e Ansprechpartner/in:</span> {sellerName}</td>',
        'sellerTel'    => '<td class="right-text font-size-11">Tel.: {sellerTel}</td>',
        'ortDatum'     => '<td class="right-text font-size-11">Ort / Datum: {ort}{datum}</td>',
        'bestellung'   => '<td class="right-text font-size-11"><span class="bold-text">Bestellnummer:</span> {bestellung}</td>',
        'date'         => '<td class="right-text font-size-11"><span class="bold-text">Voraussichtlicher Liefertermin:</span> {date}</td>',
        'placeOfIssue' => '<td class="right-text">{placeOfIssue}</td>',
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
     * @var bool
     */
    private $lastPage = false;

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
    public function Close() {
        $this->lastPage = true;
        parent::Close();
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

        if ($this->lastPage === false) {
            $this->SetY(-20);
            $this->writeHTML($footer, true, false, true, false, '');
        }
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
        $this->SetPrintHeader(false);
        $this->SetMargins(10, 12, 10);
        $this->SetFont('times');

        $this->AddPage();
        $firstPage = $this->getFirstPage();
        $this->writeHTML($firstPage, true, false, true, false, '');

        $this->AddPage();
        $lastPage  = $this->getLastPage();
        $this->writeHTML($lastPage, true, false, true, false, '');

        $this->SetMargins(7, 12, 7);
        $this->AddPage();
        $additionalPage  = $this->getAdditionalPage();
        $this->writeHTML($additionalPage, true, false, true, false, '');

        $this->Output('carpoint.pdf', 'I'); // I - browser, D - download, F - save
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
    private function getLastPage(): string
    {
        $html = '';
        $html .= $this->getStyles();
        $html .= $this->initTable();
        $html .= $this->getHeaderInfo(false);
        $html .= $this->getLastPageBody();
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
        $data[] = $this->car->getPhoneNumber() ?? null;
        $data[] = $this->car->getMobileNumber() ?? null;
        $data[] = $this->car->getEmail() ?? null;
        $data[] = $this->car->getFax() ?? null;
        $data[] = $this->car->getFirmNumber() ?? null;

        $data = array_filter($data, function($element) {
            return $element !== null;
        });

        $topLeftData = [];
        foreach ($data as $elem) {
            $topLeftData[] = str_replace('{value}', $elem, self::TOP_LEFT_DATA);
        }

        $topRightData = [];
        if ($seller = $this->car->getSeller() ?? null) {
            if ($seller->getFullNameOrNull() !== null) {
                $topRightData[] = str_replace('{sellerName}', $seller->getFullNameOrNull(), self::TOP_RIGHT_DATA['sellerName']);
            }
            if ($seller->getPhoneNumber() !== null) {
                $topRightData[] = str_replace('{sellerTel}', $seller->getPhoneNumber(), self::TOP_RIGHT_DATA['sellerTel']);
            }
        }

        $ort   = $this->car->getOrt() !== null ? $this->car->getOrt()->getTitle() : null;
        $datum = $this->car->getDatum() !== null
            ? $ort
                ? ', '.$this->car->getDatum()->format('d.m.y')
                : $this->car->getDatum()->format('d.m.y')
            : null;
        if ($ort !== null || $datum !== null) {
            $topRightData[] = str_replace(['{ort}', '{datum}'], [$ort, $datum], self::TOP_RIGHT_DATA['ortDatum']);
        }
        if (count($topRightData) !== 0) {
            $topRightData[] = '<td></td>';
        }

        $bestellung  = $this->car->getDischarge() !== null ? $this->car->getDischarge() : null;
        if ($bestellung !== null) {
            $topRightData[] = str_replace('{bestellung}', $bestellung, self::TOP_RIGHT_DATA['bestellung']);
        }
        $date = $this->car->getDate() !== null ? $this->car->getDate()->format('W/y') : null;
        if ($date !== null) {
            $topRightData[] = str_replace('{date}', $date, self::TOP_RIGHT_DATA['date']);
        }

        $placeOfIssue = $this->car->getPlaceOfIssue() !== null ? 'Auslieferungsort: '.$this->car->getPlaceOfIssue()->getTitle() : null;
        if ($placeOfIssue !== null) {
            $topRightData[] = str_replace('{placeOfIssue}', $placeOfIssue, self::TOP_RIGHT_DATA['placeOfIssue']);
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
                <td colspan="2" class="center-text font-size-15 bold-text dark-blue">Kaufvertrag / verbindliche Bestellung</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2">Hiermit bestellt nachfolgend "Käufer" genannt, verbindlich und auf der Grundlage der beiliegenden Allgemeinen Geschäftsbedingungen, folgendes Kraftfahrzeug in Serien-/Sonderausstattung bei oben genannter Firma.</td>
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

        $complStandart = null;
        if (($version = $this->car->getVersionGerman()) !== null) {
            $complStandart = $version->getStandardComplectation() !== null
                ? $version->getStandardComplectation()->getGerman()
                : null;
        }

        if ($complStandart !== null) {
            $data = '
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="bold-text">Serienausstattung:</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2">{complStandart}</td>
                </tr>
            ';
            $data = str_replace('{complStandart}', $complStandart, $data);
            $html .= $data;
        }

        $complAdditional = $this->car->getComplectationGerman();
        if ($complAdditional !== null) {
            $data = '
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="bold-text">Sonderausstattung:</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2">{complAdditional}</td>
                </tr>
            ';
            $data = str_replace('{complAdditional}', $complAdditional, $data);
            $html .= $data;
        }

        $additionalWork = $this->car->getAdditionalWork();
        if ($additionalWork !== null) {
            $data = '
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="bold-text">Gesonderte Vereinbarungen:</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2">{additionalWork}</td>
                </tr>
            ';
            $data = str_replace('{additionalWork}', $additionalWork, $data);
            $html .= $data;
        }

        return $html;
    }

    /**
     * @return string
     */
    private function getLastPageBody(): string
    {
        $newTable = $this->initTable(true);

        $text = '';
        $clientStatus = $this->car->getClientStatus();
        if ($clientStatus !== null && $clientStatus->getDescription() !== null) {
            $text .= $text === '' ? $clientStatus->getDescription() : ' '.$clientStatus->getDescription();
        }

        $carStatus = $this->car->getCarStatus();
        if ($carStatus !== null && $carStatus->getDescription() !== null) {
            $text .= $text === '' ? $carStatus->getDescription() : ' '.$carStatus->getDescription();
        }

        $taxType = $this->car->getTaxType();
        if ($taxType !== null && $taxType->getDescription() !== null) {
            $text .= $text === '' ? $taxType->getDescription() : ' '.$taxType->getDescription();
        }

        if ($text === '') {
            $newTable .= '
                <tr>
                    <td></td>
                    <td></td>
                </tr>
            ';
        } else {
            $newTable .= '
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2">{text}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
            ';
            $newTable = str_replace('{text}', $text, $newTable);
        }

        $paymentType = $this->car->getPaymentType() !== null ? $this->car->getPaymentType()->getTitle() : null;
        if ($paymentType !== null) {
            $row = '
                <tr>
                    <td>Zahlungsart:</td>
                    <td class="right-text">{paymentType}</td>
                </tr>
            ';
            $row = str_replace('{paymentType}', $paymentType, $row);
            $newTable .= $row;
        }


        $deposit  = $this->car->getDeposit() ?? null;
        if ($deposit !== null) {
            $row = '
                <tr>
                    <td>Anzahlung:</td>
                    <td class="right-text">{deposit} €</td>
                </tr>
            ';
            $row = str_replace('{deposit}', $deposit, $row);
            $newTable .= $row;
        }

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
            $newTable .= $row;

            $newTable .= '
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
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr class="center-text">
                <td>_________________________</td>
                <td>_________________________</td>
            </tr>
            <tr class="center-text">
                <td>Unterschrift / Datum Käufer</td>
                <td>Unterschrift / Datum Verkäufer</td>
            </tr>
        ';
        }

        return $newTable;
    }

    /**
     * @return string
     */
    private function getAdditionalPage(): string
    {
        $html = '';
        $html .= $this->initTable();
        $html .= '
            <tr style="font-size: 7px; text-align: justify">
                <td style="width: 48%">
I. Vertragsabschluß/Übertragung von Rechten und Pflichten des Käufers
<br>
1. Der Käufer ist an die Bestellung höchstens bis drei Wochen, bei Nutzfahrzeugen bis
sechs Wochen gebunden. Diese Frist verkürzt sich auf 10 Tage (bei Nutzfahrzeugen auf
2 Wochen) bei Fahrzeugen, die beim Verkäufer vorhanden sind. Der Kaufvertrag ist
abgeschlossen, wenn der Verkäufer die Annahme der Bestellung des näher
bezeichneten Kaufgegenstandes innerhalb der jeweils genannten Fristen schriftlich
bestätigt oder die Lieferung ausführt. Der Verkäufer ist jedoch verpflichtet, den Besteller
unverzüglich zu unterrichten, wenn er die Bestellung nicht annimmt.
<br>
2. Übertragungen von Rechten und Pflichten des Käufers aus dem Kaufvertrag bedürfen
einer schriftlichen Zustimmung des Verkäufers.
<br>
3. Bei den Neuwagen handelt es sich um EU-Neuwagen, was dem Käufer bereits vor
Vertragsabschluss mitgeteilt worden ist. Die Ausstattung der EU-Neuwagen kann auch
von der deutschen Ausführung abweichen.
<br>
4. Sobald der Kaufvertrag abgeschlossen ist, ist der Käufer an den Kauf gebunden,
weswegen eine Reklamation ausgeschlossen ist.
<br>
<br>
II. Preise
<br>
...
<br>
<br>
III. Zahlung
<br>
1. Der Kaufpreis und Preise für Nebenleistungen sind bei Übergabe des
Kaufgegenstandes und Aushändigung oder Übersendung der Rechnung zur Zahlung
fällig.
<br>
2. Gegen Ansprüche des Verkäufers kann der Käufer nur dann aufrechnen, wenn die
Gegenforderung des Käufers unbestritten ist oder ein rechtskräftiger Titel vorliegt; ein
Zurückbehaltungsrecht kann er nur geltend machen, soweit es auf Ansprüchen aus dem
Kaufvertrag beruht.
<br>
<br>
IV. Lieferung und Lieferverzug
<br>
1. Liefertermine und Lieferfristen, die verbindlich oder unverbindlich vereinbart werden
können, sind schriftlich anzugeben. Lieferfristen beginnen mit Vertragsabschluss.
<br>
2. Der Käufer kann sechs Wochen nach Überschreiten eines unverbindlichen
Liefertermins oder einer unverbindlichen Lieferfrist den Verkäufer auffordern zu liefern.
Diese Frist verkürzt sich auf 10 Tage (bei Nutzfahrzeugen auf zwei Wochen) bei
Fahrzeugen, die beim Verkäufer vorhanden sind. Mit dem Zugang der Aufforderung
kommt der Verkäufer in Verzug.
Hat der Käufer Anspruch auf Ersatz eines Verzugsschadens, beschränkt sich dieser bei
leichter Fahrlässigkeit auf höchstens 5% des vereinbarten Kaufpreises.
<br>
3. Will der Käufer darüber hinaus vom Vertrag zurücktreten und/oder Schadensersatz
statt der Leistung verlangen, muss er dem Verkäufer nach Ablauf der betreffenden Frist
gemäß Ziffer 2, Satz 1 oder 2 dieses Abschnitts eine angemessen Frist zur Lieferung
setzen.
Hat der Käfer Anspruch auf Schadensersatz statt der Leistung, beschränkt sich der
Anspruch bei leichter Fahrlässigkeit auf höchstens 25% des vereinbarten Kaufpreises.
Ist der Käufer eine juristische Person des öffentlichen Rechts, ein öffentlich-rechtliches
Sondervermögen oder ein Unternehmer, der bei Abschluss des Vertrages in Ausübung
einer gewerblichen oder selbständigen beruflichen Tätigkeit handelt, sind
Schadensersatzansprüche statt der Leistung bei leichter Fahrlässigkeit ausgeschlossen.
Wird dem Verkäufer, während er im Verzug ist, die Lieferung durch Zufall unmöglich, so
haftet er mit den vorstehend vereinbarten Haftungsbegrenzungen. Der Verkäufer haftet
nicht, wenn der Schaden auch bei rechtzeitiger Lieferung eingetreten wäre.
<br>
4. Wird ein verbindlicher Liefertermin oder eine verbindliche Lieferfrist überschritten,
kommt der Verkäufer bereits mit Überschreiten des Liefertermins oder Lieferfrist in
Verzug. Die Rechte des Käufers bestimmen sich dann nach Ziffer 2, Satz 4 und Ziffer 3
dieses Abschnitts.
<br>
5. Höhere Gewalt oder beim Verkäufer oder dessen Lieferanten eintretende
Betriebsstörungen, die den Verkäufer ohne eigenes Verschulden vorübergehend daran
hindern, den Kaufgegenstand zum vereinbarten Termin oder innerhalb der vereinbarten
Frist zu liefern, verändern die in Ziffer 1 bis 4 dieses Abschnitts genannten Termine und
Fristen um die Dauer der durch diese Umstände bedingten Leistungsstörungen. Führen
entsprechende Störungen zu einem Leistungsaufschub von mehr als vier Monaten, kann
der Käufer vom Vertrag zurücktreten. Andere Rücktrittsrechte bleiben davon unberührt.
<br>
6. Konstruktions oder Formänderungen, Abweichungen im Farbton sowie Änderungen
des Lieferumfangs seitens des Herstellers bleiben während der Lieferzeit vorbehalten,
sofern die Änderungen oder Abweichungen unter Berücksichtigung der Interessen des
Verkäufers für den Käufer zumutbar sind. Sofern der Verkäufer oder Hersteller zur
Bezeichnung der Bestellung oder des bestellten Kaufgegenstandes Zeichen oder
Nummern gebraucht, können allein daraus keine Rechte hergeleitet werden.
<br>
<br>
V. Abnahme
<br>
1. Der Käufer ist verpflichtet, den Kaufgegenstand innerhalb von 14 Tagen ab Zugang
der Bereitstellungsanzeige abzunehmen.
<br>
2. Im Falle der Nichtabnahme kann der Verkäufer von seinen gesetzlichen Rechten
Gebrauch machen. Verlangt der Verkäufer Schadensersatz, so beträgt dieser 15% des
Kaufpreises. Der Schadensersatz ist höher oder niedriger anzusetzen, wenn der
Verkäufer einen höh Auf Wunsch des Käufers, der nur unverzüglich nach Rücknahme des Kaufgegenstandes
geäußert werden kann, wird nach Wahl des Käufers ein öffentlich bestellter und
vereidigter Sachverständiger, z.B. Der Deutschen Automobil Treuhand GmbH (DAT), den
gewöhnlichen Verkaufswert ermitteln. Der Käufer trägt sämtliche Kosten der Rücknahme
und Verwertung des Kaufgegenstandes. Die Verwertungskosten betragen ohne
Nachweis 5% des gewöhnlichen Verkaufswertes. Sie sind höher oder niedriger
anzusetzen, wenn der Verkäufer höhere Kosten nachweist oder der Käufer nachweist,
dass geringere oder überhaupt keine Kosten entstanden sind.
<br>
3. Solange der Eigentumsvorbehalt besteht, darf der Käufer über den Kaufgegenstand
weder Verfügen noch dritten vertraglich eine Nutzung einräumen.
</td>
<td style="width: 4%"></td>
<td style="width: 48%">
VII. Sachmangel
<br>
1. Ansprüche des Käufers wegen Sachmängeln verjähren entsprechend den
gesetzlichen Bestimmungen in zwei Jahren ab Ablieferung des Kaufgegenstandes.
Hiervon abweichend gilt eine Verjährungsfrist von einem Jahr, wenn der Käufer eine
juristische Person des öffentlichen Rechts, ein öffentlich-rechtliches Sondervermögen
oder ein Unternehmer, der bei Abschluss des Vertrages in Ausübung seiner gewerblichen
oder selbständigen beruflichen Tätigkeit handelt.
Die in Satz 2 geregelte Verjährungsfrist von einem Jahr gilt nicht für
Schadensersatzansprüche aus Sachmangelhaftung, zu denen u.a. Auch solche wegen
Verletzung einer Nacherfüllungspflicht gehören. Für diese Ansprüche – wie für alle
anderen Schadensersatzansprüche – gelten die gesetzlichen Verjährungsfristen sowie
die Regelungen in Abschnitt VIII. Haftung.
Weitergehende Ansprüche bleiben unberührt, soweit der Verkäufer aufgrund Gesetz
zwingend haftet oder etwas anderes vereinbart wird, insbesondere im Falle der
Übernahme einer Garantie.
<br>
2. Soll eine Mängelbeseitigung durchgeführt werden, gilt folgendes:
<br>
a) Ansprüche auf Mängelbeseitigung kann der Käufer beim Verkäufer oder bei anderen,
vom Hersteller/Importeur für die Betreuung des Kaufgegenstandes aner-
kannten Betrieben geltend machen; im letzteren Fall hat der Käufer den Verkäufer
hiervon unverzüglich zu unterrichten, wenn die erste Mängelbeseitigung erfolglos war.
Bei mündlichen Anzeigen von Ansprüchen ist dem Käufer eine schriftliche Bestätigung
über den Eingang der Anzeige auszuhändigen.
<br>
b) Wird der Kaufgegenstand wegen eines Sachmangels betriebsunfähig, hat sich der
Käufer an dem Ort des betriebsunfähigen Kaufgegenstandes nächstgelegenden, vom
Hersteller/Importeur für die Betreuung des Kaufgegenstandes anerkannten
dienstbereiten Betrieb zu wenden.
<br>
c) Für die zur Mängelbeseitigung eingebauten Teile kann der Käufer bis zum Ablauf der
Verjährungsfrist des Kaufgegenstandes Sachmängelansprüche aufgrund des
Kaufvertrages geltend machen.
<br>
d) Ersetzte Teile werden Eigentum des Verkäufers.
<br>
3. Durch Eigentumswechsel am Kaufgegenstand werden Mängelbeseitigungs-
Ansprüche nicht berührt.
<br>
<br>
VIII. Haftung
<br>
1. Hat der Verkäufer aufgrund der gesetzlichen Bestimmungen für einen Schaden
aufzukommen, der leichtfahrlässig verursacht wurde, so haftet der Verkäufer beschränkt:
Die Haftung besteht nur bei Verletzung vertragswesentlicher Pflichten, etwa solcher, die
der Kaufvertrag dem Verkäufer nach seinem Inhalt und Zweck gerade auferlegen will
oder deren Erfüllung die ordnungsgemäße Durchführung des Kaufvertrages überhaupt
erst ermöglicht und auf deren Einhaltung der Käufer regelmäßig vertraut und vertrauen
darf. Diese Haftung ist auf den bei Vertragsabschluss vorhersehbaren typischen Schaden
begrenzt. Soweit der Schaden durch eine vom Käufer für den betreffenden Schadenfall
abgeschlossene Versicherung (ausgenommen Summenversicherung) gedeckt ist, haftet
der Verkäufer nur für etwaige damit verbundene Nachteile des Käufers, z.B. Höhere
Versicherungsprämien oder Zinsnachteile bis zur Schadenregulierung durch die
Versicherung.
Ist der Verkäufer eine juristische Person des öffentlichen Rechts, ein öffentlich-rechtliches
Sondervermögen oder ein Unternehmer, der bei Abschluss des Vertrages in Ausübung
seiner gewerblichen oder selbständigen beruflichen Tätigkeit handelt, und werden nach
Ablauf eines Jahres nach Ablieferung des Kaufgegenstandes Schadensersatzansprüche
wegen Sachmängeln geltend gemacht, gilt Folgendes: Die vorstehende
Haftungsbeschränkung gilt auch für einen Schaden, der grob fahrlässig verursacht
wurde, nicht aber bei grob fahrlässiger Verursachung durch gesetzliche Vertreter oder
leitende Angestellte des Verkäufers, ferner nicht für einen grob fahrlässig verursachten
Schaden, der durch eine vom Käufer für den betreffenden Schadenfall abgeschlossene
Versicherung gedeckt ist.
<br>
2. Unabhängig von einem Verschulden des Verkäufers bleibt eine etwaige Haftung des
Verkäufers bei arglistigem Verschweigen eines Mangels, aus der Übernahme einer
Garantie oder eines Beschaffungsrisikos und nach dem Produkthaftungsgesetz
unberührt.
<br>
3. Die Haftung wegen Lieferverzuges ist in Abschnitt IV abschließend geregelt.
<br>
4. Ausgeschlossen ist die persönliche Haftung der gesetzlichen Vertreter,
Erfüllungsgehilfen und Betriebsangehörigen des Verkäufers für von ihnen durch leichte
Fahrlässigkeit verursachte Schäden. Für von ihnen mit Ausnahme der gesetzlichen
Vertreter und leitenden Angestellten durch grobe Fahrlässigkeit verursachte Schäden gilt
die diesbezüglich für den Verkäufer geregelte Haftungsbeschränkung entsprechend.
<br>
5. Die Haftungsbeschränkungen dieses Abschnitts gelten nicht bei Verletzung von Leben,
Körper oder Gesundheit.
<br>
<br>
IX. Gerichtsstand
<br>
1. Für sämtliche gegenwärtigen und zukünftigen Ansprüche aus der
Geschäftsverbindung mit Kaufleuten einschließlich Wechsel- und Scheckforderungen ist
ausschließlicher Gerichtsstand der Sitz des Verkäufers.
<br>
2. Der gleiche Gerichtsstand gilt, wenn der Käufer keinen allgemeinen Gerichtsstand im
Inland hat, nach Vertragsabschluss seinen Wohnsitz oder gewöhnlichen Aufenthaltsort
aus dem Inland verlegt oder sein Wohnsitz oder gewöhnlicher Aufenthaltsort zum
Zeitpunkt der Klageerhebung nicht bekannt ist. Im Übrigen gilt bei Ansprüchen des
Verkäufers gegenüber dem Käufer dessen Wohnsitz als Gerichtsstand.
</td>
</tr>
        ';
        $html .= $this->closeTable();

        return $html;
    }
}
