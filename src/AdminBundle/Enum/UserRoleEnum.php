<?php

namespace AdminBundle\Enum;

use AdminBundle\Form\Car\RoleEightCarType;
use AdminBundle\Form\Car\RoleElevenCarType;
use AdminBundle\Form\Car\RoleFiveCarType;
use AdminBundle\Form\Car\RoleFourCarType;
use AdminBundle\Form\Car\RoleFourTeenCarType;
use AdminBundle\Form\Car\RoleNineCarType;
use AdminBundle\Form\Car\RoleOneCarType;
use AdminBundle\Form\Car\RoleSevenCarType;
use AdminBundle\Form\Car\RoleSixCarType;
use AdminBundle\Form\Car\RoleTenCarType;
use AdminBundle\Form\Car\RoleThirteenCarType;
use AdminBundle\Form\Car\RoleThreeCarType;
use AdminBundle\Form\Car\RoleTwelveCarType;
use AdminBundle\Form\Car\RoleTwoCarType;
use AdminBundle\Form\ExportExcel\RoleEightExportType;
use AdminBundle\Form\ExportExcel\RoleElevenExportType;
use AdminBundle\Form\ExportExcel\RoleFiveExportType;
use AdminBundle\Form\ExportExcel\RoleFourExportType;
use AdminBundle\Form\ExportExcel\RoleFourTeenExportType;
use AdminBundle\Form\ExportExcel\RoleNineExportType;
use AdminBundle\Form\ExportExcel\RoleOneExportType;
use AdminBundle\Form\ExportExcel\RoleSevenExportType;
use AdminBundle\Form\ExportExcel\RoleSixExportType;
use AdminBundle\Form\ExportExcel\RoleTenExportType;
use AdminBundle\Form\ExportExcel\RoleThirteenExportType;
use AdminBundle\Form\ExportExcel\RoleThreeExportType;
use AdminBundle\Form\ExportExcel\RoleTwelveExportType;
use AdminBundle\Form\ExportExcel\RoleTwoExportType;
use AdminBundle\Services\CarsTableData\RoleEightData;
use AdminBundle\Services\CarsTableData\RoleElevenData;
use AdminBundle\Services\CarsTableData\RoleFiveData;
use AdminBundle\Services\CarsTableData\RoleFourData;
use AdminBundle\Services\CarsTableData\RoleFourTeenData;
use AdminBundle\Services\CarsTableData\RoleNineData;
use AdminBundle\Services\CarsTableData\RoleOneData;
use AdminBundle\Services\CarsTableData\RoleSevenData;
use AdminBundle\Services\CarsTableData\RoleSixData;
use AdminBundle\Services\CarsTableData\RoleTenData;
use AdminBundle\Services\CarsTableData\RoleThirteenData;
use AdminBundle\Services\CarsTableData\RoleThreeData;
use AdminBundle\Services\CarsTableData\RoleTwelveData;
use AdminBundle\Services\CarsTableData\RoleTwoData;

/**
 * Class UserRoleEnum
 *
 * @package AdminBundle\Enum
 */
class UserRoleEnum
{
    public const ROLE_USER     = 'ROLE_USER';
    public const ROLE_ADMIN_1  = 'ROLE_ADMIN_1';
    public const ROLE_ADMIN_2  = 'ROLE_ADMIN_2';
    public const ROLE_ADMIN_3  = 'ROLE_ADMIN_3';
    public const ROLE_ADMIN_4  = 'ROLE_ADMIN_4';
    public const ROLE_ADMIN_5  = 'ROLE_ADMIN_5';
    public const ROLE_ADMIN_6  = 'ROLE_ADMIN_6';
    public const ROLE_ADMIN_7  = 'ROLE_ADMIN_7';
    public const ROLE_ADMIN_8  = 'ROLE_ADMIN_8';
    public const ROLE_ADMIN_9  = 'ROLE_ADMIN_9';
    public const ROLE_ADMIN_10 = 'ROLE_ADMIN_10';
    public const ROLE_ADMIN_11 = 'ROLE_ADMIN_11';
    public const ROLE_ADMIN_12 = 'ROLE_ADMIN_12';
    public const ROLE_ADMIN_13 = 'ROLE_ADMIN_13';
    public const ROLE_ADMIN_14 = 'ROLE_ADMIN_14';
    public const ROLE_ADMIN_15 = 'ROLE_ADMIN_15';

    private const CAR_FORM_TYPE = [
        self::ROLE_ADMIN_1  => RoleOneCarType::class,
        self::ROLE_ADMIN_2  => RoleTwoCarType::class,
        self::ROLE_ADMIN_3  => RoleThreeCarType::class,
        self::ROLE_ADMIN_4  => RoleFourCarType::class,
        self::ROLE_ADMIN_5  => RoleFiveCarType::class,
        self::ROLE_ADMIN_6  => RoleSixCarType::class,
        self::ROLE_ADMIN_7  => RoleSevenCarType::class,
        self::ROLE_ADMIN_8  => RoleEightCarType::class,
        self::ROLE_ADMIN_9  => RoleNineCarType::class,
        self::ROLE_ADMIN_10 => RoleTenCarType::class,
        self::ROLE_ADMIN_11 => RoleElevenCarType::class,
        self::ROLE_ADMIN_12 => RoleTwelveCarType::class,
        self::ROLE_ADMIN_13 => RoleThirteenCarType::class,
        self::ROLE_ADMIN_14 => RoleFourTeenCarType::class,
    ];

    private const CAR_EXPORT_TYPE = [
        self::ROLE_ADMIN_1  => RoleOneExportType::class,
        self::ROLE_ADMIN_2  => RoleTwoExportType::class,
        self::ROLE_ADMIN_3  => RoleThreeExportType::class,
        self::ROLE_ADMIN_4  => RoleFourExportType::class,
        self::ROLE_ADMIN_5  => RoleFiveExportType::class,
        self::ROLE_ADMIN_6  => RoleSixExportType::class,
        self::ROLE_ADMIN_7  => RoleSevenExportType::class,
        self::ROLE_ADMIN_8  => RoleEightExportType::class,
        self::ROLE_ADMIN_9  => RoleNineExportType::class,
        self::ROLE_ADMIN_10 => RoleTenExportType::class,
        self::ROLE_ADMIN_11 => RoleElevenExportType::class,
        self::ROLE_ADMIN_12 => RoleTwelveExportType::class,
        self::ROLE_ADMIN_13 => RoleThirteenExportType::class,
        self::ROLE_ADMIN_14 => RoleFourTeenExportType::class,
    ];

    private const CAR_EXPORT_STATISTIC_TYPE = [
        self::ROLE_ADMIN_1   => \AdminBundle\Form\ExportExcel\Statistics\RoleOneExportType::class,
        self::ROLE_ADMIN_15  => \AdminBundle\Form\ExportExcel\Statistics\RoleOneExportType::class,
    ];

    private const CARS_TABLE_DATA_SERVICES = [
        self::ROLE_ADMIN_1 => RoleOneData::class,
        self::ROLE_ADMIN_2 => RoleTwoData::class,
        self::ROLE_ADMIN_3 => RoleThreeData::class,
        self::ROLE_ADMIN_4 => RoleFourData::class,
        self::ROLE_ADMIN_5 => RoleFiveData::class,
        self::ROLE_ADMIN_6 => RoleSixData::class,
        self::ROLE_ADMIN_7 => RoleSevenData::class,
        self::ROLE_ADMIN_8 => RoleEightData::class,
        self::ROLE_ADMIN_9 => RoleNineData::class,
        self::ROLE_ADMIN_10 => RoleTenData::class,
        self::ROLE_ADMIN_11 => RoleElevenData::class,
        self::ROLE_ADMIN_12 => RoleTwelveData::class,
        self::ROLE_ADMIN_13 => RoleThirteenData::class,
        self::ROLE_ADMIN_14 => RoleFourTeenData::class,
    ];

    /**
     * @return array
     */
    public static function getRoles(): array
    {
        return [
            self::ROLE_ADMIN_1 => self::ROLE_ADMIN_1,
            self::ROLE_ADMIN_2 => self::ROLE_ADMIN_2,
            self::ROLE_ADMIN_3 => self::ROLE_ADMIN_3,
            self::ROLE_ADMIN_4 => self::ROLE_ADMIN_4,
            self::ROLE_ADMIN_5 => self::ROLE_ADMIN_5,
            self::ROLE_ADMIN_6 => self::ROLE_ADMIN_6,
            self::ROLE_ADMIN_7 => self::ROLE_ADMIN_7,
            self::ROLE_ADMIN_8 => self::ROLE_ADMIN_8,
            self::ROLE_ADMIN_9 => self::ROLE_ADMIN_9,
            self::ROLE_ADMIN_10 => self::ROLE_ADMIN_10,
            self::ROLE_ADMIN_11 => self::ROLE_ADMIN_11,
            self::ROLE_ADMIN_12 => self::ROLE_ADMIN_12,
            self::ROLE_ADMIN_13 => self::ROLE_ADMIN_13,
            self::ROLE_ADMIN_14 => self::ROLE_ADMIN_14,
            self::ROLE_ADMIN_15 => self::ROLE_ADMIN_15,
        ];
    }

    /**
     * @param string $role
     *
     * @return string
     */
    public static function getCarsTableDataService(string $role): string
    {
        return self::CARS_TABLE_DATA_SERVICES[$role];
    }

    /**
     * @param string $role
     *
     * @return string
     */
    public static function getCarFormType(string $role): string
    {
        return self::CAR_FORM_TYPE[$role];
    }

    /**
     * @param string $role
     *
     * @return string
     */
    public static function getExportFormType(string $role): string
    {
        return self::CAR_EXPORT_TYPE[$role];
    }

    /**
     * @param string $role
     *
     * @return string
     */
    public static function getExportStatisticFormType(string $role): string
    {
        return self::CAR_EXPORT_STATISTIC_TYPE[$role];
    }

    /**
     * @param string $role
     *
     * @return string
     */
    public static function getRoleType(string $role): string
    {
        if (in_array($role, [self::ROLE_ADMIN_1, self::ROLE_ADMIN_7, self::ROLE_ADMIN_8, self::ROLE_ADMIN_10])) {

            return 'de';
        }

        return 'pl';
    }
}