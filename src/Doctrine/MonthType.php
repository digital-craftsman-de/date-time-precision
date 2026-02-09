<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Doctrine;

use DigitalCraftsman\DateTimePrecision\Month;
use DigitalCraftsman\SelfAwareNormalizers\Doctrine\StringNormalizableType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * @deprecated
 *
 * @codeCoverageIgnore
 */
final class MonthType extends StringNormalizableType
{
    #[\Override]
    public static function getTypeName(): string
    {
        return 'dtp_month';
    }

    #[\Override]
    public static function getClass(): string
    {
        return Month::class;
    }

    #[\Override]
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $column['length'] = 7;

        return $platform->getStringTypeDeclarationSQL($column);
    }
}
