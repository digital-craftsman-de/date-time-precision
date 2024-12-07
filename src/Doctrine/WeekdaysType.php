<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Doctrine;

use DigitalCraftsman\DateTimePrecision\Weekdays;
use DigitalCraftsman\SelfAwareNormalizers\Doctrine\ArrayNormalizableType;

/**
 * @codeCoverageIgnore
 */
final class WeekdaysType extends ArrayNormalizableType
{
    public static function getTypeName(): string
    {
        return 'dtp_weekdays';
    }

    public static function getClass(): string
    {
        return Weekdays::class;
    }
}
