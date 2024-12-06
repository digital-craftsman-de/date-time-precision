<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Doctrine;

use DigitalCraftsman\DateTimePrecision\Weekday;
use DigitalCraftsman\SelfAwareNormalizers\Doctrine\StringNormalizableType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * @codeCoverageIgnore
 */
final class WeekdayType extends StringNormalizableType
{
    public static function getTypeName(): string
    {
        return 'dtp_weekday';
    }

    public static function getClass(): string
    {
        return Weekday::class;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $column['length'] = 9;

        return $platform->getStringTypeDeclarationSQL($column);
    }
}
