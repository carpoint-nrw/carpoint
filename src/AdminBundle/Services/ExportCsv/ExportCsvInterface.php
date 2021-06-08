<?php

namespace AdminBundle\Services\ExportCsv;

use AdminBundle\Entity\Car;

/**
 * Interface ExportCsvInterface
 *
 * @package AdminBundle\Services\ExportCsv
 */
interface ExportCsvInterface
{
    /**
     * @param array $cars
     *
     * @return string|null
     */
    public function export(array $cars):? string;
}