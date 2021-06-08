<?php

namespace AdminBundle\Enum;

/**
 * Class CarConditionEnum
 *
 * @package AdminBundle\Enum
 */
class CarConditionEnum
{
    public const SOLD = 'sold';
    public const RESERVATION = 'reservation';

    private const CAR_CONDITION = [
        self::SOLD => self::SOLD,
        self::RESERVATION => self::RESERVATION,
    ];

    /**
     * @param string $carCondition
     *
     * @return string
     */
    public static function getCarCondition(string $carCondition): string
    {
        if (in_array(lcfirst($carCondition), self::CAR_CONDITION)) {
            return self::CAR_CONDITION[lcfirst($carCondition)];
        }
        return '';
    }
}