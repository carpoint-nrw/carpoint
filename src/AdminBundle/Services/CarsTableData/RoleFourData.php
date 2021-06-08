<?php

namespace AdminBundle\Services\CarsTableData;

use AdminBundle\Entity\User\Admin;

/**
 * Class RoleFourData
 *
 * @package AdminBundle\Services\CarsTableData
 */
class RoleFourData extends AbstractCarTableData
{
    /**
     * @param array $cars
     * @param Admin $admin
     *
     * @return array
     */
    public function getData(array $cars, Admin $admin): array
    {
        $data = [];
        foreach ($cars as $car) {
            $abbreviation = '';
            if ($car->getUser() !== null) {
                $abbreviation = $car->getUser()->getAbbreviation() !== null
                    ? $car->getUser()->getAbbreviation()
                    : $car->getUser()->getFirmNumber();
            }

            $data[] = [
                'id' => $car->getId(),
                'vendor' => $car->getVendor() !== null ? $car->getVendor()->getTitle() : '',
                'customer' => $car->getCustomer() !== null ? $car->getCustomer()->getTitle() : '',
                'vinNumber' => $car->getVinNumber(),
                'brand' => $car->getBrand() === null ? null : $car->getBrand()->getTitle(),
                'model' => $car->getModel() === null ? null : $car->getModel()->getTitle(),
                'versionPolish' => $car->getVersionPolish() === null ? null : $car->getVersionPolish()->getPolish(),
                'versionGerman' => $car->getVersionGerman() === null ? null : $car->getVersionGerman()->getGerman(),
                'carRegistration' => $car->getCarRegistration() !== null ? $car->getCarRegistration()->format('m.y') : '',
                'carMileage' => $car->getCarMileage(),
                'initialVatPrice' => $car->getInitialVatPrice() === null
                    ? ''
                    : number_format($car->getInitialVatPrice(), 0, '.', '.') . ($car->getInitialVatPriceType() === 'EUR' ? ' €' : ' zl'),
                'initialPriceWithOutVat' => $car->getInitialPriceWithOutVat() === null
                    ? ''
                    : number_format($car->getInitialPriceWithOutVat(), 0, '.', '.') . ($car->getInitialPriceWithOutVatType() === 'EUR' ? ' €' : ' zl'),
                'ourDiscountPrice' => $car->getOurDiscountPrice() === null
                    ? ''
                    : number_format($car->getOurDiscountPrice(), 0, '.', '.'),
                'discount' => round($car->getDiscount(), 1) <= 0 ? '' : round($car->getDiscount(), 1),
                'completed' => $car->getCompleted() !== null ? $car->getCompleted()->format('d.m') : '',
                'invoiceNumber' => $car->getInvoiceNumber(),
                'paid' => $car->isPaid() === null ? false : $car->isPaid(),
                'shippingCost' => $car->getShippingCost() === null
                    ? ''
                    : number_format($car->getShippingCost(), 0, '.', '.') . ($car->getShippingCostType() === 'EUR' ? ' €' : ' zl'),
                'transportInvoiceNumber' => $car->getTransportInvoiceNumber(),
                'orderNumber' => $car->getOrderNumber(),
                'user' => $abbreviation,
                'salePriceWithOutVAT' => $car->getSalePriceWithOutVAT() === null
                    ? ''
                    : number_format($car->getSalePriceWithOutVAT(), 0, '.', '.') . ($car->getSalePriceWithOutVATType() === 'EUR' ? ' €' : ' zl'),
                'salePriceWithVAT' => $car->getSalePriceWithVAT() === null
                    ? ''
                    : number_format($car->getSalePriceWithVAT(), 0, '.', '.') . ($car->getSalePriceWithVATType() === 'EUR' ? ' €' : ' zl'),
                'salesInvoiceNumber' => $car->getSalesInvoiceNumber(),
                'paidSuccess' => $car->isPaidSuccess() === null ? false : $car->isPaidSuccess(),
                'invoiceDate' => $car->getInvoiceDate() !== null ? $car->getInvoiceDate()->format('d.m.Y') : '',
                'declaration' => $car->getDeclaration(),
                'importTax' => $car->getImportTax() === null ? '' : $car->getImportTax() . ' zl',
                'taxNumber' => $car->getTaxNumber(),
                'taxReturned' => $car->isTaxReturned() === null ? false : $car->isTaxReturned(),
                'editDate' => $car->getEditDate(),
                'salesmanId' => $car->getSalesman() !== null ? $car->getSalesman()->getId() : '',
                'booking' => $this->getPermissionForCarCondition($car, $admin),
                'pay' => $car->isPay(),
                'payColor' => $this->getPayColor($car, 'getPayClick'),
                'paidColor' => $this->getPayColor($car, 'getPaidClick'),
                'carCreatedAt' => $car->getCarCreatedAt() === null ? false : true,
                'carColor' => $this->getCarColor($car, $admin),
                'terminColor' => $this->getTerminColor($car),
            ];
        }
        return $data;
    }
}