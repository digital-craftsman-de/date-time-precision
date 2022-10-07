<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\Doctrine;

use DigitalCraftsman\DateTimeParts\ValueObject\Month;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class MonthType extends StringType
{
    /** @codeCoverageIgnore */
    public function getName(): string
    {
        return 'digital_craftsman_month';
    }

    /** @param Month|null $value */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        return (string) $value;
    }

    /** @param string|null $value */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Month
    {
        return $value === null
            ? null
            : Month::fromString($value);
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $column['length'] = 7;

        return $platform->getStringTypeDeclarationSQL($column);
    }
}
