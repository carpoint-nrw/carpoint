<?php

namespace AdminBundle\Services\CarsTableData;

use AdminBundle\Entity\User\Admin;

/**
 * Class RoleFourTeenData
 *
 * @package AdminBundle\Services\CarsTableData
 */
class RoleFourTeenData extends AbstractCarTableData
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
                    : number_format($car->getInitialVatPrice(), 0, '.', '.') . ($car->getInitialVatPriceType() === 'EUR' ? ' €' : ' zl'),
                'initialPriceWithOutVat' => $car->getInitialPriceWithOutVat() === null
                    ? ''
                    : number_format($car->getInitialPriceWithOutVat(), 0, '.', '.') . ($car->getInitialPriceWithOutVatType() === 'EUR' ? ' €' : ' zl'),
                'ourDiscountPrice' => $car->getOurDiscountPrice() === null
                    ? ''
                    : number_format($car->getOurDiscountPrice(), 0, '.', '.'),
                'discount' => round($car->getDiscount(), 1) <= 0 ? '' : round($car->getDiscount(), 1),
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
                'documents' => $car->getDocuments(),
                'downloadDate' => $car->getDownloadDate() !== null ? $car->getDownloadDate()->format('d.m') : '',
                'targetUnload' => $car->getTargetUnload() !== null ? $car->getTargetUnload()->getTitle() : '',
                'forwarder' => $car->getForwarder() !== null ? $car->getForwarder()->getTitle() : '',
                'shippingCost' => $car->getShippingCost() === null
                    ? ''
                    : number_format($car->getShippingCost(), 0, '.', '.') . ($car->getShippingCostType() === 'EUR' ? ' €' : ' zl'),
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
                'invoiceDate' => $car->getInvoiceDate() !== null ? $car->getInvoiceDate()->format('d.m.y') : '',
                'information' => $car->getInformation(),
                'seller' => $car->getSeller() !== null ? $car->getSeller()->getFullName() : '',
                'editDate' => $car->getEditDate(),
                'salesmanId' => $car->getSalesman() !== null ? $car->getSalesman()->getId() : '',
                'booking' => $this->getPermissionForCarCondition($car, $admin),
                'targetUnloadData' => $targetUnloadResult,
                'forwarderData' => $forwarderResult,
                'locationData' => $locationResult,
                'userData' => $userResult,
                'carCreatedAt' => $car->getCarCreatedAt() === null ? false : true,
                'addedToArchiveDe' => $car->getAddedToArchiveDe(),
                'addedToArchivePl' => $car->getAddedToArchivePl(),
                'carColor' => $this->getCarColor($car, $admin),
                'terminColor' => $this->getTerminColor($car),

                'zakupBrut' => $car->getZakupBrut(),
                'vat' => $car->getVat(),
                'dataPro2' => $car->getDataPro2() !== null ? $car->getDataPro2()->format('d.m.y') : '',
                'dataFv2' => $car->getDataFv2() !== null ? $car->getDataFv2()->format('d.m.y') : '',
                'zysk' => $car->getZysk(),
                'demo' => $car->getDemo(),
                'ekBrutto' => $car->getEkBrutto(),
                'createdAt' => $car->getCreatedAt() !== null ? $car->getCreatedAt()->format('d.m.Y') : '',
                'carlineDate' => $car->getCarlineDate() !== null ? $car->getCarlineDate()->format('d.m.Y') : '',
                'carlineNumber' => $car->getCarlineNumber(),
                'uploader' => $car->getUploader() !== null ? $car->getUploader()->getFirstName() : '',
                'showPrice' => $car->getShowPrice(),
                'nrPro2' => $car->getNrPro2(),
            ];
        }
        return $data;
    }
}