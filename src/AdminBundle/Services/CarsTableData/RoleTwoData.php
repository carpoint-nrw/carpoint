<?php

namespace AdminBundle\Services\CarsTableData;

use AdminBundle\Entity\User\Admin;

/**
 * Class RoleTwoData
 *
 * @package AdminBundle\Services\CarsTableData
 */
class RoleTwoData extends AbstractCarTableData
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
        [$targetUnloadResult, $forwarderResult, $locationResult, $userResult] = $this->getSelectInputsData(true, true, true, true);
        foreach ($cars as $car) {
            $complStandartGerman = '';
            if (($version = $car->getVersionGerman()) !== null) {
                $complStandartGerman = $version->getStandardComplectation() !== null
                    ? $version->getStandardComplectation()->getGerman()
                    : '';
            }
            $complStandartPolish = '';
            if (($version = $car->getVersionGerman()) !== null) {
                $complStandartPolish = $version->getStandardComplectation() !== null
                    ? $version->getStandardComplectation()->getPolish()
                    : '';
            }

            $abbreviation = '';
            if ($car->getUser() !== null) {
                $abbreviation = $car->getUser()->getAbbreviation() !== null
                    ? $car->getUser()->getAbbreviation()
                    : $car->getUser()->getFirmNumber();
            }

            $data[] = [
                'id' => $car->getId(),
                'vendor' => $car->getVendor() !== null ? $car->getVendor()->getTitle() : '',
                'place' => $car->getPlace() !== null ? $car->getPlace()->getTitle() : '',
                'customer' => $car->getCustomer() !== null ? $car->getCustomer()->getTitle() : '',
                'carCondition' => $car->getCarCondition(),
                'vinNumber' => $car->getVinNumber(),
                'brand' => $car->getBrand() === null ? null : $car->getBrand()->getTitle(),
                'model' => $car->getModel() === null ? null : $car->getModel()->getTitle(),
                'versionPolish' => $car->getVersionPolish() === null ? null : $car->getVersionPolish()->getPolish(),
                'versionGerman' => $car->getVersionGerman() === null ? null : $car->getVersionGerman()->getGerman(),
                'colorPolish' => $car->getColorPolish() !== null ? $car->getColorPolish()->getPolish() : '',
                'colorGerman' => $car->getColorGerman() !== null ? $car->getColorGerman()->getGerman() : '',
                'polishComplectation' => $complStandartPolish,
                'germanComplectation' => $complStandartGerman,
                'complectationPolish' => $car->getComplectationPolish(),
                'complectationGerman' => $car->getComplectationGerman(),
                'carRegistration' => $car->getCarRegistration() !== null ? $car->getCarRegistration()->format('m.y') : '',
                'carMileage' => $car->getCarMileage(),
                'initialVatPrice' => $car->getInitialVatPrice() === null
                    ? ''
                    : number_format($car->getInitialVatPrice(), 0, '.', '.'),
                'initialPriceWithOutVat' => $car->getInitialPriceWithOutVat() === null
                    ? ''
                    : number_format($car->getInitialPriceWithOutVat(), 0, '.', '.') . ($car->getInitialPriceWithOutVatType() === 'EUR' ? ' €' : ' zl'),
                'ourDiscountPrice' => $car->getOurDiscountPrice() === null
                    ? ''
                    : number_format($car->getOurDiscountPrice(), 0, '.', '.'),
                'discount' => round($car->getDiscount(), 1) <= 0 ? '' : round($car->getDiscount(), 1),
                'minimumSellingPrice' => $car->getMinimumSellingPrice() === null
                    ? ''
                    : number_format($car->getMinimumSellingPrice(), 0, '.', '.') . ($car->getMinimumSellingPriceType() === 'EUR' ? ' €' : ' zl'),
                'priceRoleFive' => $car->getPriceRoleFive() === null
                    ? ''
                    : number_format($car->getPriceRoleFive(), 0, '.', '.') . ($car->getPriceRoleFiveType() === 'EUR' ? ' €' : ' zl'),
                'priceRoleSix' => $car->getPriceRoleSix() === null
                    ? ''
                    : number_format($car->getPriceRoleSix(), 0, '.', '.') . ($car->getPriceRoleSixType() === 'EUR' ? ' €' : ' zl'),
                'priceRoleSeven' => $car->getPriceRoleSeven() === null
                    ? ''
                    : number_format($car->getPriceRoleSeven(), 0, '.', '.') . ($car->getPriceRoleSevenType() === 'EUR' ? ' €' : ' zl'),
                'completed' => $car->getCompleted() !== null ? $car->getCompleted()->format('d.m') : '',
                'invoiceNumber' => $car->getInvoiceNumber(),
                'paymentDate' => $car->getPaymentDate() !== null ? $car->getPaymentDate()->format('d.m') : '',
                'paid' => $car->isPaid() === null ? false : $car->isPaid(),
                'documents' => $car->getDocuments(),
                'downloadDate' => $car->getDownloadDate() !== null ? $car->getDownloadDate()->format('d.m') : '',
                'targetUnload' => $car->getTargetUnload() !== null ? $car->getTargetUnload()->getTitle() : '',
                'forwarder' => $car->getForwarder() !== null ? $car->getForwarder()->getTitle() : '',
                'shippingCost' => $car->getShippingCost() === null
                    ? ''
                    : number_format($car->getShippingCost(), 0, '.', '.') . ($car->getShippingCostType() === 'EUR' ? ' €' : ' zl'),
                'transportInvoiceNumber' => $car->getTransportInvoiceNumber(),
                'location' => $car->getLocation() !== null ? $car->getLocation()->getTitle() : '',
                'orderNumber' => $car->getOrderNumber(),
                'radioCode' => $car->getRadioCode(),
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
                'information' => $car->getInformation(),
                'importTax' => $car->getImportTax() === null ? '' : $car->getImportTax() . ' zl',
                'taxNumber' => $car->getTaxNumber(),
                'taxReturned' => $car->isTaxReturned() === null ? false : $car->isTaxReturned(),
                'editDate' => $car->getEditDate(),
                'salesmanId' => $car->getSalesman() !== null ? $car->getSalesman()->getId() : '',
                'booking' => $this->getPermissionForCarCondition($car, $admin),
                'targetUnloadData' => $targetUnloadResult,
                'forwarderData' => $forwarderResult,
                'locationData' => $locationResult,
                'userData' => $userResult,
                'pay' => $car->isPay(),
                'payColor' => $this->getPayColor($car, 'getPayClick'),
                'paidColor' => $this->getPayColor($car, 'getPaidClick'),
                'carCreatedAt' => $car->getCarCreatedAt() === null ? false : true,
                'addedToArchiveDe' => $car->getAddedToArchiveDe(),
                'addedToArchivePl' => $car->getAddedToArchivePl(),
                'carColor' => $this->getCarColor($car, $admin),
                'terminColor' => $this->getTerminColor($car),

                'zakupBrut' => $car->getZakupBrut(),
                'vat' => $car->getVat(),
                'nrPro' => $car->getNrPro(),
                'dataPro' => $car->getDataPro() !== null ? $car->getDataPro()->format('d.m') : '',
                'nrFv' => $car->getNrFv(),
                'dataFv' => $car->getDataFv() !== null ? $car->getDataFv()->format('d.m.Y') : '',
                'pay4' => $car->isPay4(),
                'data1' => $car->getData1() !== null ? $car->getData1()->format('d.m.Y') : '',
                'data2' => $car->getData2() !== null ? $car->getData2()->format('d.m.Y') : '',
                'nrPro2' => $car->getNrPro2(),
                'dataPro2' => $car->getDataPro2() !== null ? $car->getDataPro2()->format('d.m.Y') : '',
                'dataFv2' => $car->getDataFv2() !== null ? $car->getDataFv2()->format('d.m.Y') : '',
                'zysk' => $car->getZysk(),
                'demo' => $car->getDemo(),
                'segregator' => $car->getSegregator(),
                'createdAt' => $car->getCreatedAt() !== null ? $car->getCreatedAt()->format('d.m.Y') : '',
                'carlineDate' => $car->getCarlineDate() !== null ? $car->getCarlineDate()->format('d.m.Y') : '',
                'carlineNumber' => $car->getCarlineNumber(),
                'uploader' => $car->getUploader() !== null ? $car->getUploader()->getFirstName() : '',
                'showPrice' => $car->getShowPrice(),
                'seller' => $car->getSeller() !== null ? $car->getSeller()->getFullName() : '',
            ];
        }
        return $data;
    }
}