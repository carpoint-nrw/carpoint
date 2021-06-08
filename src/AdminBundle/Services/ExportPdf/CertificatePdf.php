<?php

namespace AdminBundle\Services\ExportPdf;

use AdminBundle\Entity\Car;
use AdminBundle\Entity\References\Color;

/**
 * Class CertificatePdf
 *
 * @package AdminBundle\Services\ExportPdf
 */
class CertificatePdf extends AbstractExportPdf
{
    private const CAR_DATA = [
        'Marke'             => 'getBrand',
        'Modell'            => 'getModel',
        'Fahrzeugart'       => 'getBodyType',
        'Kraftstoffart'     => 'getFuel',
        'Außenfarbe'        => 'getColorGerman',
        'Fahrgestellnummer' => 'getVinNumber',
    ];

    private const TOP_LEFT_DATA = '<td class="font-size-11">{value}</td>';

    private const TOP_RIGHT_DATA = [
        'carInvoiceNumber' => '<td class="right-text font-size-11"><span class="bold-text">Prof-Rechnungsnummer:</span> {carInvoiceNumber}</td>',
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

        $this->SetPrintHeader(false);
        $this->SetMargins(10, 12, 10);
        $this->SetFont('times');

        $this->AddPage();
        $firstPage = $this->getFirstPage();
        $this->writeHTML($firstPage, true, false, true, false, '');

        $this->Output('Proforma.pdf', 'I'); // I - browser, D - download, F - save
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

        $topLeftData   = [str_replace('{value}', 'KFZ-Zulassungsbehörde', self::TOP_LEFT_DATA)];
        $topRightData  = [];

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
                <td colspan="2" class="center-text font-size-15 bold-text dark-blue">Bestätigung für die Kraftfahrzeug-Zulassungsstelle</td>
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
            if (is_object($data)) {
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
            if (is_string($data)) {
                $row = $tr;
                $row = str_replace(['{name}', '{value}'], [$name, $data], $row);
                $html .= $row;
                continue;
            }
        }

        $row = '
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2">Hiermit bestätigen wir, dass das o.g. Fahrzeug von uns importiert worden ist und sich in unserem Eigentum befindet, bis es mit Begleichung der Rechnung auf den Erwerber übergeht.  Das Fahrzeug steht bei uns auf dem Gelände, auf der Weserstr. 3 in 47506 Neukirchen-Vluyn.</td>
            </tr>
            <tr>
                <td colspan="2">Die Besteuerung dieses innergemeinschaftlichen Erwerbs (§ 1 Abs. 1 Nr. 5 i.V. mit § 1a UstG) werden wir als gewerblich angemeldetes Unternehmen im allgemeinen Besteuerungsverfahren nach § 18 Abs. 1 bis 4 UstG durchführen.</td>
            </tr>
            <tr>
                <td colspan="2">Des Weiteren wird bestätigt, dass die o.g. Fahrgestellnummer mit der in dem beigefügten internationalen Datenblatt (COC) und auch mit der an dem o.g. Fahrzeug eingeschlagenen Nummer übereinstimmt.</td>
            </tr>
        ';
        $html .= $row;

        $carRegistrationCertificate = $this->car->getRegistrationCertificate() !== null
            ? $this->car->getRegistrationCertificate()->getDescription()
            : null;

        if ($carRegistrationCertificate !== null) {
            $row = '
                <tr>
                    <td colspan="2">{carRegistrationCertificate}</td>
                </tr>
            ';
            $row = str_replace('{carRegistrationCertificate}', $carRegistrationCertificate, $row);
            $html .= $row;
        }

        $carRegistrationDescription = $this->car->getRegistrationCertificateDescription() ?? null;
        if ($carRegistrationDescription !== null) {
            $row = '
                <tr>
                    <td colspan="2">{carRegistrationDescription}</td>
                </tr>
            ';
            $row = str_replace('{carRegistrationDescription}', $carRegistrationDescription, $row);
            $html .= $row;
        }

        return $html;
    }
}