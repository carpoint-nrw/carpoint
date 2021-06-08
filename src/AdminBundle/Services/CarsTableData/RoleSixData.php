<?php

namespace AdminBundle\Services\CarsTableData;

use AdminBundle\Entity\User\Admin;

/**
 * Class RoleSixData
 *
 * @package AdminBundle\Services\CarsTableData
 */
class RoleSixData extends AbstractCarTableData
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
        [$targetUnloadResult, $forwarderResult, $locationResult, $userResult] = $this->getSelectInputsData(false, false, false, true);
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
                'polishComplectation' => $car->getStandartComplectationPolish(),
                'germanComplectation' => $car->getStandartComplectationGerman(),
                'complectationPolish' => $car->getComplectationPolish(),
                'complectationGerman' => $car->getComplectationGerman(),
                'carRegistration' => $car->getCarRegistration() !== null ? $car->getCarRegistration()->format('m.y') : '',
                'carMileage' => $car->getCarMileage(),
                'initialVatPrice' => $car->getInitialVatPrice() === null
                    ? ''
                    : number_format($car->getInitialVatPrice(), 0, '.', '.') . ($car->getInitialVatPriceType() === 'EUR' ? ' €' : ' zl'),
                'initialPriceWithOutVat' => $car->getInitialPriceWithOutVat() === null
                    ? ''
                    : number_format($car->getInitialPriceWithOutVat(), 0, '.', '.') . ($car->getInitialPriceWithOutVatType() === 'EUR' ? ' €' : ' zl'),
                'minimumSellingPrice' => $car->getMinimumSellingPrice() === null
                    ? ''
                    : number_format($car->getMinimumSellingPrice(), 0, '.', '.') . ($car->getMinimumSellingPriceType() === 'EUR' ? ' €' : ' zl'),
                'priceRoleSix' => $car->getPriceRoleSix() === null
                    ? ''
                    : number_format($car->getPriceRoleSix(), 0, '.', '.') . ($car->getPriceRoleSixType() === 'EUR' ? ' €' : ' zl'),
                'completed' => $car->getCompleted() !== null ? $car->getCompleted()->format('d.m') : '',
                'paid' => $car->isPaid() === null ? false : $car->isPaid(),
                'documents' => $car->getDocuments(),
                'downloadDate' => $car->getDownloadDate() !== null ? $car->getDownloadDate()->format('d.m') : '',
                'targetUnload' => $car->getTargetUnload() !== null ? $car->getTargetUnload()->getTitle() : '',
                'forwarder' => $car->getForwarder() !== null ? $car->getForwarder()->getTitle() : '',
                'shippingCost' => $car->getShippingCost() === null
                    ? ''
                    : number_format($car->getShippingCost(), 0, '.', '.') . ($car->getShippingCostType() === 'EUR' ? ' €' : ' zl'),
                'location' => $car->getLocation() !== null ? $car->getLocation()->getTitle() : '',
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
                'declaration' => $car->getDeclaration(),
                'editDate' => $car->getEditDate(),
                'salesmanId' => $car->getSalesman() !== null ? $car->getSalesman()->getId() : '',
                'booking' => $this->getPermissionForCarCondition($car, $admin),
                'userData' => $userResult,
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