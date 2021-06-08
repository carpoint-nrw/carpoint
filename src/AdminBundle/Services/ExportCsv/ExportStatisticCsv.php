<?php

namespace AdminBundle\Services\ExportCsv;

use Symfony\Component\Serializer\Serializer;

/**
 * Class ExportStatisticCsv
 *
 * @package AdminBundle\Services\ExportCsv
 */
class ExportStatisticCsv implements ExportCsvInterface
{
    /**
     * @var string
     */
    private $filesPath;

    /**
     * @var string
     */
    private $filesRelativePath;

    /**
     * ExportStatisticCsv constructor.
     *
     * @param string $filesPath
     * @param string $filesRelativePath
     */
    public function __construct(string $filesPath, string $filesRelativePath)
    {
        $this->filesPath         = $filesPath;
        $this->filesRelativePath = $filesRelativePath;
    }

    /**
     * @param array $cars
     *
     * @return string|null
     */
    public function export(array $cars):? string
    {
        try {
            $filename = $this->filesPath.'/data.csv';
            $handle   = fopen($filename, 'w+');

            fputcsv($handle, [
                'VK Brutto',
                'Best nr.',
                'Rech. Nr.',
                'Rech. Datum',
                'Umsatzsteuer',
                'Fahrgnr.',
            ], ',');

            foreach($cars as $car) {
                $vkBrutto     = $car->getSellingPrice() !== null ? $car->getSellingPrice() : null;
                $status       = $car->getClientStatus() !== null ? $car->getClientStatus()->getTitle() : null;
                $km           = $car->getCarMileage();
                $taxType      = $car->getTaxType() !== null ? $car->getTaxType()->getTitle() : null;
                $vin          = $car->getVinNumber();
                $model        = $car->getModel() !== null ? $car->getModel()->getTitle() : null;
                $taxTypeValue = null;
                $vinValue     = $model.' '.substr($vin, -7);

                if (in_array($taxType, [
                    'inkl. 16% Ust.',
                    'inkl. 16% Ust. ( Export)',
                    'inkl. 19% Ust.',
                    'inkl. 19% Ust. ( Export)',
                ])) {
                    if (in_array($status, ['Privat', 'Gewerberteibende'])) {
                        if ($km === '' || $km === null) {
                            $taxTypeValue = 8403;
                        } else {
                            $taxTypeValue = 8402;
                        }
                    }
                } elseif (in_array($taxType, [
                    'umsatzsteuerfrei nach §25a UStG',
                    'umsatzsteuerfrei nach §25a UStG (Export)',
                ])) {
                    if (in_array($status, ['Privat', 'Gewerberteibende'])) {
                        $taxTypeValue = 8001;
                    }
                } elseif (in_array($taxType, [
                    'umsatzsteuerfrei nach §4 Nr.1a UStG (Export außerhalb der EU)',
                ])) {
                    if (in_array($status, ['Privat', 'Gewerberteibende'])) {
                        $taxTypeValue = 8120;
                    }
                } elseif (in_array($taxType, [
                    'umsatzsteuerfrei nach §4 Nr.1b UStG (Export innerhalb der EU)',
                ])) {
                    if (in_array($status, ['Gewerberteibende'])) {
                        $taxTypeValue = 8125;
                        $vinValue .= ' '.$car->getFirmNumber();
                    }
                }

                fputcsv($handle, [
                    $vkBrutto !== null
                        ? number_format($vkBrutto, 0, '.', '.')
                        : null,
                    $car->getDischarge(),
                    $car->getCarInvoiceNumber(),
                    $car->getCarInvoiceDate() !== null ? $car->getCarInvoiceDate()->format('d.m.y') : '',
                    $taxTypeValue,
                    $vinValue
                ], ',');
            }
            fclose($handle);

            return $this->filesRelativePath.'/data.csv';
        } catch (\Throwable $exception) {
            return null;
        }
    }
}