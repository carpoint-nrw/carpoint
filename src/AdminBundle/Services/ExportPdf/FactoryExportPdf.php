<?php

namespace AdminBundle\Services\ExportPdf;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class FactoryExportPdf
 *
 * @package AdminBundle\Services\ExportPdf
 */
class FactoryExportPdf
{

    /**
     * @param string $name
     *
     * @return ExportPdfInterface
     */
    public function getExportService(string $name): ExportPdfInterface
    {
        $service = null;

        switch ($name) {
            case DeedPdf::class:
                $service = new DeedPdf();
                break;
            case CarlineDeedPdf::class:
                $service = new CarlineDeedPdf();
                break;
            case InvoicePdf::class:
                $service = new InvoicePdf();
                break;
            case InvoiceAccount::class:
                $service = new InvoiceAccount();
                break;
            case CertificatePdf::class:
                $service = new CertificatePdf();
                break;
        }

        return $service;
    }
}
