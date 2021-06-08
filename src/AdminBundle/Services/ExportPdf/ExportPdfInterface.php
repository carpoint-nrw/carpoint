<?php

namespace AdminBundle\Services\ExportPdf;

use AdminBundle\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Interface ExportPdfInterface
 *
 * @package AdminBundle\Services\ExportPdf
 */
interface ExportPdfInterface
{

    /**
     * @param Car   $car
     * @param array $params
     *
     * @return void
     */
    public function export(Car $car, array $params): void;
}
