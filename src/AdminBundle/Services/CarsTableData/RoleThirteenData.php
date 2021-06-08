<?php

namespace AdminBundle\Services\CarsTableData;

use AdminBundle\Entity\User\Admin;

/**
 * Class RoleThirteenData
 *
 * @package AdminBundle\Services\CarsTableData
 */
class RoleThirteenData extends AbstractCarTableData
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
                'carCondition' => $car->getCarCondition(),
                'fhnr' => $car->getFhnr(),
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
                'location' => $car->getLocation() !== null ? $car->getLocation()->getTitle() : '',
                'orderNumber' => $car->getOrderNumber(),
                'radioCode' => $car->getRadioCode(),
                'user' => $abbreviation,
                'information' => $car->getInformation(),
                'discharge' => $car->getDischarge(),
                'sellingPrice' => $car->getSellingPrice() === null
                    ? ''
                    : $car->getSellingPrice() . ' €',
                'client' => $client,
                'seller' => $car->getSeller() !== null ? $car->getSeller()->getFullName() : '',
                'additionalWork' => $car->getAdditionalWork(),
                'notes' => $car->getNotes(),
                'date' => $car->getDate() !== null ? $car->getDate()->format('d.m.Y') : '',
                'placeOfIssue' => $car->getPlaceOfIssue() !== null ? $car->getPlaceOfIssue()->getTitle() : '',
                'editDate' => $car->getEditDate(),
                'salesmanId' => $car->getSalesman() !== null ? $car->getSalesman()->getId() : '',
                'booking' => $this->getPermissionForCarCondition($car, $admin),
                'targetUnloadData' => $targetUnloadResult,
                'forwarderData' => $forwarderResult,
                'locationData' => $locationResult,
                'userData' => $userResult,
                'payColor' => $this->getPayColor($car, 'getPayClick'),
                'paidColor' => $this->getPayColor($car, 'getPaidClick'),
                'carCreatedAt' => $car->getCarCreatedAt() === null ? false : true,
                'addedToArchiveDe' => $car->getAddedToArchiveDe(),
                'addedToArchivePl' => $car->getAddedToArchivePl(),
                'carColor' => $this->getCarColor($car, $admin),
                'terminColor' => $this->getTerminColor($car),

                'ekNetto' => $car->getEkNetto(),
                'zakupBrut' => $car->getZakupBrut(),
                'datum' => $car->getDatum() !== null ? $car->getDatum()->format('d.m.Y') : '',
                'demo' => $car->getDemo(),
                'ekBrutto' => $car->getEkBrutto(),
                'ust' => $car->getUst(),
                'createdAt' => $car->getCreatedAt() !== null ? $car->getCreatedAt()->format('d.m.Y') : '',
                'uploader' => $car->getUploader() !== null ? $car->getUploader()->getFirstName() : '',
                'showPrice' => $car->getShowPrice(),
            ];
        }
        return $data;
    }
}