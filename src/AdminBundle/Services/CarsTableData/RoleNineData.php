<?php

namespace AdminBundle\Services\CarsTableData;

use AdminBundle\Entity\User\Admin;

/**
 * Class RoleNineData
 *
 * @package AdminBundle\Services\CarsTableData
 */
class RoleNineData extends AbstractCarTableData
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

            if ($car->getFirma() !== null && $car->getFirma() !== '') {
                $client = $car->getFirma() !== null ? $car->getFirma() : '';
            } else {
                $client = $car->getLastName() !== null ? $car->getLastName() : '';
            }

            $data[] = [
                'id' => $car->getId(),
                'vendor' => $car->getVendor() !== null ? $car->getVendor()->getTitle() : '',
                'place' => $car->getPlace() !== null ? $car->getPlace()->getTitle() : '',
                'customer' => $car->getCustomer() !== null ? $car->getCustomer()->getTitle() : '',
                'fhnr' => $car->getFhnr(),
                'discharge' => $car->getDischarge(),
                'client' => $client,
                'radioCode' => $car->getRadioCode(),
                'carCondition' => $car->getCarCondition(),
                'user' => $abbreviation,
                'userData' => $userResult,
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
                'completed' => $car->getCompleted() !== null ? $car->getCompleted()->format('d.m') : '',
                'ourDiscountPrice' => $car->getOurDiscountPrice() === null
                    ? ''
                    : number_format($car->getOurDiscountPrice(), 0, '.', '.'),
                'initialPriceWithOutVat' => $car->getInitialPriceWithOutVat() === null
                    ? ''
                    : number_format($car->getInitialPriceWithOutVat(), 0, '.', '.') . ($car->getInitialPriceWithOutVatType() === 'EUR' ? ' €' : ' zl'),
                'initialVatPrice' => $car->getInitialVatPrice() === null
                    ? ''
                    : number_format($car->getInitialVatPrice(), 0, '.', '.') . ($car->getInitialVatPriceType() === 'EUR' ? ' €' : ' zl'),
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
                'carRegistration' => $car->getCarRegistration() !== null ? $car->getCarRegistration()->format('m.y') : '',
                'carMileage' => $car->getCarMileage(),
                'invoiceNumber' => $car->getInvoiceNumber(),
                'paid' => $car->isPaid() === null ? false : $car->isPaid(),
                'documents' => $car->getDocuments(),
                'downloadDate' => $car->getDownloadDate() !== null ? $car->getDownloadDate()->format('d.m') : '',
                'forwarder' => $car->getForwarder() !== null ? $car->getForwarder()->getTitle() : '',
                'forwarderData' => $forwarderResult,
                'targetUnload' => $car->getTargetUnload() !== null ? $car->getTargetUnload()->getTitle() : '',
                'targetUnloadData' => $targetUnloadResult,
                'shippingCost' => $car->getShippingCost() === null
                    ? ''
                    : number_format($car->getShippingCost(), 0, '.', '.') . ($car->getShippingCostType() === 'EUR' ? ' €' : ' zl'),
                'transportInvoiceNumber' => $car->getTransportInvoiceNumber(),
                'pay' => $car->isPay(),
                'payColor' => $this->getPayColor($car, 'getPayClick'),
                'location' => $car->getLocation() !== null ? $car->getLocation()->getTitle() : '',
                'locationData' => $locationResult,
                'orderNumber' => $car->getOrderNumber(),
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
                'sellingPrice' => $car->getSellingPrice() === null
                    ? ''
                    : $car->getSellingPrice() . ' €',
                'seller' => $car->getSeller() !== null ? $car->getSeller()->getFullName() : '',
                'additionalWork' => $car->getAdditionalWork(),
                'notes' => $car->getNotes(),
                'date' => $car->getDate() !== null ? $car->getDate()->format('d.m.Y') : '',
                'placeOfIssue' => $car->getPlaceOfIssue() !== null ? $car->getPlaceOfIssue()->getTitle() : '',
                'declaration' => $car->getDeclaration(),
                'importTax' => $car->getImportTax() === null ? '' : $car->getImportTax() . ' zl',
                'taxNumber' => $car->getTaxNumber(),
                'taxReturned' => $car->isTaxReturned() === null ? false : $car->isTaxReturned(),
                'editDate' => $car->getEditDate(),
                'salesmanId' => $car->getSalesman() !== null ? $car->getSalesman()->getId() : '',
                'booking' => $this->getPermissionForCarCondition($car, $admin),
                'carCreatedAt' => $car->getCarCreatedAt() === null ? false : true,
                'carColor' => $this->getCarColor($car, $admin),
                'terminColor' => $this->getTerminColor($car),

                'ekNetto' => $car->getEkNetto(),
                'vat' => $car->getVat(),
                'data2' => $car->getData2() !== null ? $car->getData2()->format('d.m.Y') : '',
                'preisTr' => $car->getPreisTr(),
                'pay5' => $car->isPay5(),
                'nrPro2' => $car->getNrPro2(),
                'dataPro2' => $car->getDataPro2() !== null ? $car->getDataPro2()->format('d.m.Y') : '',
                'dataFv2' => $car->getDataFv2() !== null ? $car->getDataFv2()->format('d.m.Y') : '',
                'datum' => $car->getDatum() !== null ? $car->getDatum()->format('d.m.Y') : '',
                'paymentDate' => $car->getPaymentDate() !== null ? $car->getPaymentDate()->format('d.m') : '',
                'zakupBrut' => $car->getZakupBrut(),
                'demo' => $car->getDemo(),
                'ekBrutto' => $car->getEkBrutto(),
                'ust' => $car->getUst(),
                'paidColor' => $this->getPayColor($car, 'getPaidClick'),
                'createdAt' => $car->getCreatedAt() !== null ? $car->getCreatedAt()->format('d.m.Y') : '',
                'uploader' => $car->getUploader() !== null ? $car->getUploader()->getFirstName() : '',
                'showPrice' => $car->getShowPrice(),
            ];
        }
        return $data;
    }
}