<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Doctrine;

use DigitalCraftsman\DateTimePrecision\Year;
use DigitalCraftsman\SelfAwareNormalizers\Doctrine\IntNormalizableType;

/**
 * @deprecated
 *
 * @codeCoverageIgnore
 */
final class YearType extends IntNormalizableType
{
    #[\Override]
    public static function getTypeName(): string
    {
        return 'dtp_year';
    }

    #[\Override]
    public static function getClass(): string
    {
        return Year::class;
    }
}
