<?php

namespace AdminBundle\Services\CarsTableData;

use AdminBundle\Entity\User\Admin;

/**
 * Class RoleTenData
 *
 * @package AdminBundle\Services\CarsTableData
 */
class RoleTenData extends AbstractCarTableData
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
        [$targetUnloadResult, $forwarderResult, $locationResult] = $this->getSelectInputsData(false, false, true);
        foreach ($cars as $car) {
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
                'versionPolish' => $car->getVersionPolish() === null ? null : $car->getVersionPolish()->getPolish(),
                'versionGerman' => $car->getVersionGerman() === null ? null : $car->getVersionGerman()->getGerman(),
                'colorGerman' => $car->getColorGerman() !== null ? $car->getColorGerman()->getGerman() : '',
                'germanComplectation' => $car->getStandartComplectationGerman(),
                'complectationGerman' => $car->getComplectationGerman(),
                'carRegistration' => $car->getCarRegistration() !== null ? $car->getCarRegistration()->format('m.y') : '',
                'carMileage' => $car->getCarMileage(),
                'ourDiscountPrice' => $car->getOurDiscountPrice() === null
                    ? ''
                    : number_format($car->getOurDiscountPrice(), 0, '.', '.'),
                'completed' => $car->getCompleted() !== null ? $car->getCompleted()->format('d.m') : '',
                'paid' => $car->isPaid() === null ? false : $car->isPaid(),
                'documents' => $car->getDocuments(),
                'downloadDate' => $car->getDownloadDate() !== null ? $car->getDownloadDate()->format('d.m') : '',
                'shippingCost' => $car->getShippingCost() === null
                    ? ''
                    : number_format($car->getShippingCost(), 0, '.', '.') . ($car->getShippingCostType() === 'EUR' ? ' €' : ' zl'),
                'transportInvoiceNumber' => $car->getTransportInvoiceNumber(),
                'location' => $car->getLocation() !== null ? $car->getLocation()->getTitle() : '',
                'radioCode' => $car->getRadioCode(),
                'salePriceWithOutVAT' => $car->getSalePriceWithOutVAT() === null
                    ? ''
                    : number_format($car->getSalePriceWithOutVAT(), 0, '.', '.') . ($car->getSalePriceWithOutVATType() === 'EUR' ? ' €' : ' zl'),
                'salePriceWithVAT' => $car->getSalePriceWithVAT() === null
                    ? ''
                    : number_format($car->getSalePriceWithVAT(), 0, '.', '.') . ($car->getSalePriceWithVATType() === 'EUR' ? ' €' : ' zl'),
                'information' => $car->getInformation(),
                'discharge' => $car->getDischarge(),
                'sellingPrice' => $car->getSellingPrice() === null
                    ? ''
                    : number_format($car->getSellingPrice(), 0, '.', '.') . ' €',
                'client' => $client,
                'seller' => $car->getSeller() !== null ? $car->getSeller()->getFullName() : '',
                'additionalWork' => $car->getAdditionalWork(),
                'notes' => $car->getNotes(),
                'date' => $car->getDate() !== null ? $car->getDate()->format('d.m.Y') : '',
                'placeOfIssue' => $car->getPlaceOfIssue() !== null ? $car->getPlaceOfIssue()->getTitle() : '',
                'editDate' => $car->getEditDate(),
                'salesmanId' => $car->getSalesman() !== null ? $car->getSalesman()->getId() : '',
                'booking' => $this->getPermissionForCarCondition($car, $admin),
                'locationData' => $locationResult,
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