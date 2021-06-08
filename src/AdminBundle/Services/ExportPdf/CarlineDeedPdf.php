<?php

namespace AdminBundle\Services\ExportPdf;

use AdminBundle\Entity\Car;
use AdminBundle\Entity\Currency;
use AdminBundle\Entity\References\Color;
use AdminBundle\Entity\References\Model;
use AdminBundle\Entity\References\Version;
use AdminBundle\Entity\User\User;
use AdminBundle\Entity\User\UserOrderNumber;
use AdminBundle\Enum\CarShowPrices;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CarlineDeedPdf
 *
 * @package AdminBundle\Services\ExportPdf
 */
class CarlineDeedPdf extends AbstractExportPdf
{
    private const CAR_DATA = [
        'Modell'            => 'getModel',
        'Ausführung'        => 'getVersionGerman',
        'Außenfarbe'        => 'getColorGerman',
        'Fahrgestellnummer' => 'getVinNumber',
        'Erstzulassung'     => 'getCarRegistration',
        'Laufleistung'      => 'getCarMileage',
    ];

    private const TOP_LEFT_DATA = '<td class="font-size-11">{value}</td>';

    private const TOP_RIGHT_DATA = [
        'ortDatum'     => '<td class="right-text font-size-11">Datum: Orzech, {datum}</td>',
        'bestellung'   => '<td class="right-text font-size-11"><span class="bold-text">Bestellnummer:</span> {bestellung}</td>',
        'date'         => '<td class="right-text font-size-11"><span class="bold-text">Voraussichtlicher Liefertermin:</span> {date}</td>',
    ];

    private const TOP_DATA = [
        ['left' => null, 'right' => null],
        ['left' => null, 'right' => null],
        ['left' => null, 'right' => null],
        ['left' => null, 'right' => null],
        ['left' => null, 'right' => null],
    ];

    /**
     * @var bool
     */
    private $lastPage = false;

    /**
     * @var Car
     */
    private $car;

    /**
     * @var array
     */
    private $params;

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
        if (isset($this->params['type']) && $this->params['type'] !== null) {
            $value = $this->params['type'] == 'pln'
                ? 'Bankverbindung PLN: PKO BP Numer konta: PL98 1020 1068 0000 1602 0364 2790'
                : 'Bankverbindung Euro: PKO BP Numer konta: PL81 1020 1068 0000 1002 0364 2808';
        } else {
            $priceType = $this->car->getSalePriceWithOutVATType();
            $value     = $priceType == 'PLN'
                ? 'Bankverbindung PLN: PKO BP Numer konta: PL98 1020 1068 0000 1602 0364 2790'
                : 'Bankverbindung Euro: PKO BP Numer konta: PL81 1020 1068 0000 1002 0364 2808';
        }

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
                    <td></td>
                    <td>_________________________</td>
                </tr>
                <tr>
                    <td></td>
                    <td> Unterschrift / Datum Käufer</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2">___________________________________________________________________________________________________________</td>
                </tr>
                <tr>
                    <td class="center-text dark-blue" colspan="2">Carline S.C * Inhaber: Iwona Rezler-Witek und Eugen Maier * Malinowa 842-622 Orzech</td>
                </tr>
                <tr>
                    <td class="center-text dark-blue" colspan="2">{value}</td>
                </tr>
                <tr>
                    <td class="center-text dark-blue" colspan="2">SWIFT/BIC: BPKOPLPW * Ust. ID Nummer: PL 6452560338</td>
                </tr>
            </table>
        ';

        $footer = str_replace('{value}', $value, $footer);

        if ($this->lastPage) {
            $this->SetY(-30);
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
        $this->car    = $car;
        $this->params = $params;
        $this->SetFont('times');
        $this->SetPrintHeader(false);
        $this->addPage();

        $html = '';
        $html .= $this->getStyles();
        $html .= $this->initTable();
        $html .= $this->getUsersInfo();
        $html .= $this->getBody();
        $html .= $this->getFooter();
        $html .= $this->closeTable();

        $this->writeHTML($html, true, false, true, false, '');
        $this->Output('carline.pdf', 'I'); // I - browser, D - download, F - save
    }

    /**
     * @return string
     */
    private function getStyles(): string
    {
        return '
            <style>
                .carpoint-image {
                    width: 90px;
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
                .dark-blue {
                    color: #040452;
                }
                .font-size-9 {
                    font-size: 9px;
                }
            </style>
        ';
    }

    /**
     * @return string
     */
    private function initTable(): string
    {
        return '<table class="justify-text font-size-doc">';
    }

    /**
     * @return string
     */
    private function closeTable(): string
    {
        return '</table>';
    }

    /**
     * @return string
     */
    private function getUsersInfo()
    {
        $html = '
            <tr>
                <td></td>
                <td class="right-text"><img src="files/carline.png" alt="" class="carpoint-image"></td>
            </tr>
            <tr>
                <td></td>
                <td class="right-text">EU-Wagen Großhandel</td>
            </tr>
            <tr>
                <td></td>
                <td class="right-text">Tel. DE:  +49 162 4086 350</td>
            </tr>
            <tr>
                <td></td>
                <td class="right-text">Tel. PL:  +48 533333491</td>
            </tr>
            <tr>
                <td></td>
                <td class="right-text">www.carlineb2b.pl</td>
            </tr>
            <tr>
                <td class="font-size-9">Carline S.C   Mlinowa 8, 42-622 Orzech</td>
                <td class="right-text">info@carlineb2b.pl</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
        ';

        $data   = [];
        $client = $this->car->getUser();
        if ($client === null && isset($this->params['user']) && $this->params['user'] instanceof User) {
            $client = $this->params['user'];
        }

        if ($client !== null) {
            $data[] = $client->getFirstName() !== null && $client->getLastName() !== null ? $client->getFirstName() . ' ' . $client->getLastName() : null;
            $data[] = $client->getFirmNumber() ?? null;
            $data[] = $client->getStreet() ?? null;
            $data[] = $client->getPlaceIndex() !== null && $client->getCity() !== null ? $client->getPlaceIndex() . ' ' . $client->getCity() : null;
            $data[] = $client->getUstIdNr() ?? null;
        }

        $data   = array_filter($data, function($element) {
            return $element !== null;
        });

        $topLeftData = [];
        foreach ($data as $elem) {
            $topLeftData[] = str_replace('{value}', $elem, self::TOP_LEFT_DATA);
        }

        $topRightData   = [];
        $datum          = (new \DateTime())->format('d.m.y');
        $topRightData[] = str_replace(['{datum}'], [$datum], self::TOP_RIGHT_DATA['ortDatum']);

        $bestellung = null;
        if (isset($this->params['user'])) {
            $user = $this->params['user'];
            if ($user instanceof User) {
                $em = $this->params['em'];
                $userOrderNumber = $em->getRepository(UserOrderNumber::class)
                    ->findOneBy(['user' => $user, 'car' => $this->car]);

                $bestellung = $userOrderNumber !== null ? $userOrderNumber->getNumber() : null;
            } else {
                $bestellung = $this->car->getCarlineNumber() !== null ? $this->car->getCarlineNumber() : null;
            }
        }

        if ($bestellung !== null) {
            $topRightData[] = str_replace('{bestellung}', $bestellung, self::TOP_RIGHT_DATA['bestellung']);
        }

        $date = $this->car->getDate() !== null ? $this->car->getDate()->format('W/y') : null;
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

            $leftData  = $resultLine['left'] === null ? '<td></td>' : $resultLine['left'];
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
    private function getBody(): string
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

            if ($data instanceof Color) {
                if ($data->getGerman() !== null) {
                    $row = $tr;
                    $row = str_replace(['{name}', '{value}'], [$name, $data->getGerman()], $row);
                    $html .= $row;
                }
                continue;
            }
            if ($data instanceof Version) {
                if ($data->getGerman() !== null) {
                    $row = $tr;
                    $row = str_replace(['{name}', '{value}'], [$name, $data->getGerman()], $row);
                    $html .= $row;
                }
                continue;
            }
            if ($data instanceof Model) {
                $row = $tr;
                $row = str_replace(['{name}', '{value}'], [$name, $this->car->getBrand()->getTitle().' '.$data->getTitle()], $row);
                $html .= $row;
                continue;
            }
            if (is_object($data) && !$data instanceof \DateTime) {
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

        $html .= '
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
    private function getFooter(): string
    {
        if (isset($this->params['type'])) {
            $showPrice = $this->car->getShowPrice();
            $priceType = mb_strtoupper($this->params['type']);
            switch ($showPrice) {
                case CarShowPrices::PRISE_1:
                    $price = $this->car->getPriceRoleFive();
                    break;
                case CarShowPrices::PRISE_2:
                    $price = $this->car->getPriceRoleSix();
                    break;
                case CarShowPrices::PRISE_3:
                    $price = $this->car->getPriceRoleSeven();
                    break;
                default:
                    $price = '';
            }

            $em       = $this->params['em'];
            $currency = $em->getRepository(Currency::class)->findBy([], ['id'=>'DESC'], 1, 0);
            if ($priceType === 'EUR' && $currency !== null) {
                $price = $price / $currency[0]->getOurCurrency();
                $price = $price !== '' ? number_format($price, 2, ',', '.') . ' €' : $price;
            } else {
                $price = $price !== '' ? number_format($price, 2, ',', '.') . ' PLN' : $price;
            }
        } else {
            $price     = $this->car->getSalePriceWithOutVAT();
            $priceType = $this->car->getSalePriceWithOutVATType();
            if ($priceType === 'EUR') {
                $price = $price !== null ? number_format($price, 2, ',', '.') . ' €' : $price;
            } else {
                $price = $price !== null ? number_format($price, 2, ',', '.') . ' PLN' : $price;
            }
        }

        $price2 = 0;
        $price2 = number_format($price2, 2, ',', '.').($priceType === 'EUR' ? ' €' : ' PLN');

        $html = '
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr class="font-size-12">
                <td>Kaufpreis Netto exkl. MwSt.:</td>
                <td class="right-text">{price}</td>
            </tr>
            <tr class="font-size-12">
                <td>Verkauf Netto, Steuerfrei</td>
                <td class="right-text">{price2}</td>
            </tr>
            <tr class="font-size-12">
                <td>Kaufpreis Brutto:</td>
                <td class="right-text">{price}</td>
            </tr>
        ';

        $html = str_replace(['{price}', '{price2}'], [$price, $price2], $html);

        return $html;
    }
}