<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\Doctrine;

use DigitalCraftsman\DateTimeParts\ValueObject\Year;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;

final class YearType extends IntegerType
{
    /** @codeCoverageIgnore */
    public function getName(): string
    {
        return 'digital_craftsman_year';
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
