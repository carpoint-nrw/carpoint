<?php

namespace AdminBundle\Services\CarsTableData;

use AdminBundle\Entity\User\Admin;

/**
 * Class RoleTwelveData
 *
 * @package AdminBundle\Services\CarsTableData
 */
class RoleTwelveData extends AbstractCarTableData
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
                'customer' => $car->getCustomer() !== null ? $car->getCustomer()->getTitle() : '',
                'carCondition' => $car->getCarCondition(),
                'fhnr' => $car->getFhnr(),
                'vinNumber' => $car->getVinNumber(),
                'brand' => $car->getBrand() === null ? null : $car->getBrand()->getTitle(),
                'model' => $car->getModel() === null ? null : $car->getModel()->getTitle(),
                'versionGerman' => $car->getVersionGerman() === null ? null : $car->getVersionGerman()->getGerman(),
                'colorGerman' => $car->getColorGerman() !== null ? $car->getColorGerman()->getGerman() : '',
                'germanComplectation' => $complStandartGerman,
                'complectationGerman' => $car->getComplectationGerman(),
                'carRegistration' => $car->getCarRegistration() !== null ? $car->getCarRegistration()->format('m.y') : '',
                'carMileage' => $car->getCarMileage(),
                'initialVatPrice' => $car->getInitialVatPrice() === null
                    ? ''
                    : number_format($car->getInitialVatPrice(), 0, '.', '.') . ($car->getInitialVatPriceType() === 'EUR' ? ' €' : ' zl'),
                'initialPriceWithOutVat' => $car->getInitialPriceWithOutVat() === null
                    ? ''
                    : number_format($car->getInitialPriceWithOutVat(), 0, '.', '.') . ($car->getInitialPriceWithOutVatType() === 'EUR' ? ' €' : ' zl'),
                'completed' => $car->getCompleted() !== null ? $car->getCompleted()->format('d.m') : '',
                'paid' => $car->isPaid() === null ? false : $car->isPaid(),
                'documents' => $car->getDocuments(),
                'downloadDate' => $car->getDownloadDate() !== null ? $car->getDownloadDate()->format('d.m') : '',
                'targetUnload' => $car->getTargetUnload() !== null ? $car->getTargetUnload()->getTitle() : '',
                'forwarder' => $car->getForwarder() !== null ? $car->getForwarder()->getTitle() : '',
                'location' => $car->getLocation() !== null ? $car->getLocation()->getTitle() : '',
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
                'datum' => $car->getDatum() !== null ? $car->getDatum()->format('d.m.Y') : '',
                'demo' => $car->getDemo(),
                'ekBrutto' => $car->getEkBrutto(),
                'ust' => $car->getUst(),
                'invoiceNumber' => $car->getInvoiceNumber(),
                'orderNumber' => $car->getOrderNumber(),
                'createdAt' => $car->getCreatedAt() !== null ? $car->getCreatedAt()->format('d.m.Y') : '',
                'uploader' => $car->getUploader() !== null ? $car->getUploader()->getFirstName() : '',
            ];
        }
        return $data;
    }
}