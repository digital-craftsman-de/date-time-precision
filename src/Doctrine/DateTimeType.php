<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Doctrine;

use DigitalCraftsman\DateTimePrecision\DateTime;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class DateTimeType extends Type
{
    /** @codeCoverageIgnore */
    public function getName(): string
    {
        return 'digital_craftsman_date_time';
    }

    /** @codeCoverageIgnore */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getDateTimeTypeDeclarationSQL($column);
    }

    /** @param DateTime|null $value */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        return $value->format($platform->getDateTimeFormatString());
    }

    /** @param string|null $value */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?DateTime
    {
        return $value === null
            ? null
            : DateTime::fromString($value);
    }

    /** @codeCoverageIgnore */
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
