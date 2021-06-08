<?php

namespace AppBundle\Traits;

use AdminBundle\Entity\Car;

/**
 * Trait CarTrait
 *
 * @package AppBundle\Traits
 */
trait CarTrait
{
    /**
     * @param Car $car
     *
     * @return string
     */
    protected function getVinNumber(Car $car): string
    {
        $vinNumber = $car->getVinNumber();
        $vinNumber = substr($vinNumber, -5);

        return 'ID' . $vinNumber;
    }

    /**
     * @param Car $car
     *
     * @return string
     */
    protected function getDate(Car $car): string
    {
        if (($date = $car->getCompleted()) === null) {

            return '';
        }

        $currentDate = new \DateTime();

        if ($date < $currentDate) {

            return 'Lagerfahrzeug';
        }

        return $date->format('d.m.Y');
    }

    /**
     * @param array $cars
     * @param string $search
     *
     * @return array
     */
    protected function sortCarsWithSearch(array $cars, string $search): array
    {
        $result = [];

        $length = iconv_strlen($search);

        if ($length === 0) {

            return $cars;
        }

        if ($length !== 5) {

            return [];
        }

        foreach ($cars as $car) {
            $vinNumber = $car->getVinNumber();
            $vinNumber = substr($vinNumber, -5);

            if ($search === $vinNumber) {
                $result[] = $car;
            }
        }

        return $result;
    }
}