<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Car;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class MissedNumberController
 *
 * @Route("/missed-numbers")
 *
 * @package AdminBundle\Controller
 */
class MissedNumberController extends Controller
{
    /**
     * @Route("")
     * @Template
     *
     * @return Response|array
     */
    public function indexAction()
    {
        $em             = $this->getDoctrine()->getManager();
        $invoiceNumbers = $em->getRepository(Car::class)->getInvoiceNumbers();

        $invoiceNumbersByYear = [];
        $duplicates           = [];

        foreach ($invoiceNumbers as $invoiceNumber) {
            if (
                isset($invoiceNumbersByYear[$invoiceNumber['carInvoiceNumberYear']])
                && in_array($invoiceNumber['carInvoiceNumber'], $invoiceNumbersByYear[$invoiceNumber['carInvoiceNumberYear']])
            ) {
                $duplicates[] = $invoiceNumber['carInvoiceNumberYear'].'-'.str_pad($invoiceNumber['carInvoiceNumber'], 4, 0, STR_PAD_LEFT);
                continue;
            }
            $invoiceNumbersByYear[$invoiceNumber['carInvoiceNumberYear']][] = $invoiceNumber['carInvoiceNumber'];
        }

        $missedNumbers = [];
        foreach ($invoiceNumbersByYear as $year => $numbers) {
            $temp   = range(reset($numbers), end($numbers));
            $missed = array_diff($temp, $numbers);

            foreach ($missed as $value) {
                $missedNumbers[] = $year.'-'.str_pad($value, 4, 0, STR_PAD_LEFT);
            }
        }

        return [
            'missed'     => $missedNumbers,
            'duplicates' => $duplicates
        ];
    }
}