<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Doctrine;

use DigitalCraftsman\DateTimePrecision\Time;
use DigitalCraftsman\SelfAwareNormalizers\Doctrine\StringNormalizableType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * @codeCoverageIgnore
 */
final class TimeType extends StringNormalizableType
{
    public static function getTypeName(): string
    {
        return 'dtp_time';
    }

    public static function getClass(): string
    {
        return Time::class;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getTimeTypeDeclarationSQL($column);
    }
}
