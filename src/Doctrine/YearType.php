<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Doctrine;

use DigitalCraftsman\DateTimePrecision\Year;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class YearType extends Type
{
    /** @codeCoverageIgnore */
    public function getName(): string
    {
        return 'digital_craftsman_year';
    }

    /** @codeCoverageIgnore */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($column);
    }

    /** @param Year|null $value */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?int
    {
        return $value === null
            ? null
            : $value->year;
    }

    /** @param int|null $value */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Year
    {
        return $value === null
            ? null
            : new Year($value);
    }

    /** @codeCoverageIgnore */
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
