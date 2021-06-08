<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Car;
use AdminBundle\Enum\CarConditionEnum;
use AdminBundle\Services\ExportPdf\CertificatePdf;
use AdminBundle\Services\ExportPdf\DeedPdf;
use AdminBundle\Services\ExportPdf\FactoryExportPdf;
use AdminBundle\Services\ExportPdf\InvoiceAccount;
use AdminBundle\Services\ExportPdf\InvoicePdf;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Class CarExportPdfController
 *
 * @Route("/export-pdf")
 *
 * @package AdminBundle\Controller
 */
class CarExportPdfController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var FactoryExportPdf
     */
    private $factoryExportPdf;

    /**
     * @var Car
     */
    private $car;

    /**
     * @var string
     */
    private $carInvoicePath;

    /**
     * CarExportPdfController constructor.
     *
     * @param EntityManagerInterface $em
     * @param FactoryExportPdf       $factoryExportPdf
     */
    public function __construct(
        EntityManagerInterface $em,
        FactoryExportPdf $factoryExportPdf,
        string $carInvoicePath
    ) {
        $this->em               = $em;
        $this->factoryExportPdf = $factoryExportPdf;
        $this->carInvoicePath   = $carInvoicePath;
    }

    /**
     * @Route("/deed/{id}/{type}", requirements={"id"="\d+"}, defaults={ "id": "0", "type": null })
     *
     * @param Request     $request
     * @param string      $id
     * @param string|null $type
     *
     * @return RedirectResponse
     */
    public function deedExport(Request $request, string $id, $type): RedirectResponse
    {
        $this->car = $this->em->getRepository(Car::class)->find($id);

        if ($type === 'statistic' && ($this->car === null || $this->car->getDischarge() === null)) {
            return $this->redirect($request->headers->get('referer'));
        }

        if ($this->car->getDatum() === null) {
            $this->car->setDatum(new \DateTime());
            $this->em->persist($this->car);
            $this->em->flush();
        }

        return $this->exportPdf($id, DeedPdf::class);
    }

    /**
     * @Route("/invoice-account/{id}/{type}", requirements={"id"="\d+"}, defaults={ "id": "0", "type": null })
     *
     * @param Request     $request
     * @param string      $id
     * @param string|null $type
     *
     * @return RedirectResponse
     */
    public function invoiceAccountExport(Request $request, string $id, $type): RedirectResponse
    {
        try {
            $this->car = $this->em->getRepository(Car::class)->find($id);

            if ($type === 'statistic' && ($this->car === null || $this->car->getProformaNumber() === null)) {
                return $this->redirect($request->headers->get('referer'));
            }

            if ($this->car->getProformaNumber() === null) {
                $proformaNumber = $this->em->getRepository(Car::class)->findMaxProformaNumber();
                $proformaNumber = $proformaNumber === null ? 1000 : (int) $proformaNumber + 1;
                $this->car->setProformaNumber($proformaNumber);
                $this->em->persist($this->car);
                $number = true;
            }
            if ($this->car->getProformaDate() === null) {
                $this->car->setProformaDate((new \DateTime())->setTime(0, 0, 0));
                $this->em->persist($this->car);
                $date = true;
            }

            $this->em->flush();

            return $this->exportPdf($id, InvoiceAccount::class);
        } catch (\Throwable $exception) {
            if ($number === true) {
                $this->car->setProformaNumber(null);
                $this->em->persist($this->car);
            }
            if ($date === true) {
                $this->car->setProformaDate(null);
                $this->em->persist($this->car);
            }
            $this->em->flush();

            return $this->redirect($request->headers->get('referer'));
        }
    }

    /**
     * @Route("/certificate/{id}", requirements={"id"="\d+"}, defaults={ "id": "0" })
     *
     * @param string $id
     *
     * @return RedirectResponse
     */
    public function certificateExport(string $id): RedirectResponse
    {
        return $this->exportPdf($id, CertificatePdf::class);
    }

    /**
     * @Route("/invoice/{id}/{type}", requirements={"id"="\d+"}, defaults={ "id": "0", "type": null })
     *
     * @param Request     $request
     * @param string      $id
     * @param string|null $type
     *
     * @return mixed
     */
    public function invoiceExport(Request $request, string $id, $type)
    {
        try {
            $this->car = $this->em->getRepository(Car::class)->find($id);

            if ($type === 'statistic' && ($this->car === null || $this->car->getCarInvoiceNumber() === null)) {
                return $this->redirect($request->headers->get('referer'));
            }

            if ($this->car === null || $this->car->isZahldatumPay() === false || $this->car->getCarCondition() !== CarConditionEnum::SOLD) {
                return $this->redirect($request->headers->get('referer'));
            }

            if ($this->car->getCarInvoiceNumber() === null) {
                $currentYear   = (int) date('Y');
                $invoiceNumber = $this->em->getRepository(Car::class)->findMaxInvoiceNumber($currentYear);
                $invoiceNumber = $invoiceNumber === null ? 1 : (int) $invoiceNumber + 1;
                $this->car->setCarInvoiceNumberYear($currentYear);
                $this->car->setCarInvoiceNumber($invoiceNumber);
                $this->em->persist($this->car);
                $number = true;
            }
            if ($this->car->getCarInvoiceDate() === null) {
                $this->car->setCarInvoiceDate((new \DateTime())->setTime(0, 0, 0));
                $this->em->persist($this->car);
                $date = true;
            }

            $fileName = $this->car->getInvoiceFileName();
            if ($fileName !== null && file_exists($this->carInvoicePath.'/'.$fileName)) {
                return $this->file(
                    $this->carInvoicePath.'/'.$fileName,
                    $fileName,
                    ResponseHeaderBag::DISPOSITION_INLINE
                );
            } else {
                $fileName       = '';
                $fileNameValues = [
                    $this->car->getCarInvoiceNumber(),
                    $this->car->getModel() !== null ? $this->car->getModel()->getTitle() : null,
                    $this->car->getVinNumber(),
                    $this->car->getFirma() !== null ? $this->car->getFirma() : $this->car->getLastName(),
                ];

                foreach ($fileNameValues as $value) {
                    if ($value !== null) {
                        $fileName .= $fileName === '' ? $value : '_'.$value;
                    }
                }
                $fileName .= '.pdf';

                $this->car->setInvoiceFileName($fileName);
                $name = true;
            }

            $this->em->flush();

            return $this->exportPdf(
                $id,
                InvoicePdf::class,
                [
                    'filePath' => $this->carInvoicePath,
                    'fileName' => $fileName,
                ]
            );
        } catch (\Throwable $exception) {
            if ($number === true) {
                $this->car->setCarInvoiceNumberYear(null);
                $this->car->setCarInvoiceNumber(null);
                $this->em->persist($this->car);
            }
            if ($date === true) {
                $this->car->setCarInvoiceDate(null);
                $this->em->persist($this->car);
            }
            if ($name === true) {
                $this->car->setInvoiceFileName(null);
                $this->em->persist($this->car);
            }
            $this->em->flush();

            return $this->redirect($request->headers->get('referer'));
        }
    }

    /**
     * @param string $id
     * @param string $pdfType
     * @param array  $params
     *
     * @return RedirectResponse
     */
    private function exportPdf(string $id, string $pdfType, array $params = []): RedirectResponse
    {
        $car = $this->car === null
            ? $this->em->getRepository(Car::class)->find($id)
            : $this->car;

        if ($car === null) {

            return $this->redirectToRoute('admin_car_index');
        }

        $service = $this->factoryExportPdf->getExportService($pdfType);
        $service->export($car, $params);

        return $this->redirectToRoute('admin_car_edit', ['id' => $id]);
    }
}