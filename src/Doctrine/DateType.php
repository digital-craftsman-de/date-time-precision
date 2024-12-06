<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Doctrine;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\SelfAwareNormalizers\Doctrine\StringNormalizableType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * @codeCoverageIgnore
 */
final class DateType extends StringNormalizableType
{
    public static function getTypeName(): string
    {
        return 'dtp_date';
    }

    public static function getClass(): string
    {
        return Date::class;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getDateTypeDeclarationSQL($column);
    }
}
