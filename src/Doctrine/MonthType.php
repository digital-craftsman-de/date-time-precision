<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Doctrine;

use DigitalCraftsman\DateTimePrecision\Month;
use DigitalCraftsman\SelfAwareNormalizers\Doctrine\StringNormalizableType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * @codeCoverageIgnore
 */
final class MonthType extends StringNormalizableType
{
    public static function getTypeName(): string
    {
        return 'dtp_month';
    }

    public static function getClass(): string
    {
        return Month::class;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $column['length'] = 7;

        return $platform->getStringTypeDeclarationSQL($column);
    }
}
