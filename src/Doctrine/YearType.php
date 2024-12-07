<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Doctrine;

use DigitalCraftsman\DateTimePrecision\Year;
use DigitalCraftsman\SelfAwareNormalizers\Doctrine\IntNormalizableType;

/**
 * @codeCoverageIgnore
 */
final class YearType extends IntNormalizableType
{
    public static function getTypeName(): string
    {
        return 'dtp_year';
    }

    public static function getClass(): string
    {
        return Year::class;
    }
}
