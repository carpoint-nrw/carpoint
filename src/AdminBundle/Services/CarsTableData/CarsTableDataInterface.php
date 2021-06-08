<?php

namespace AdminBundle\Services\CarsTableData;

use AdminBundle\Entity\User\Admin;

/**
 * Interface CarsTableDataInterface
 *
 * @package AdminBundle\Services\CarsTableData
 */
interface CarsTableDataInterface
{
    /**
     * @param array $cars
     * @param Admin $admin
     *
     * @return array
     */
    public function getData(array $cars, Admin $admin): array;
}