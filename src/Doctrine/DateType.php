<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Doctrine;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\SelfAwareNormalizers\Doctrine\StringNormalizableType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * @deprecated
 *
 * @codeCoverageIgnore
 */
final class DateType extends StringNormalizableType
{
    #[\Override]
    public static function getTypeName(): string
    {
        return 'dtp_date';
    }

    #[\Override]
    public static function getClass(): string
    {
        return Date::class;
    }

    #[\Override]
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getDateTypeDeclarationSQL($column);
    }
}
