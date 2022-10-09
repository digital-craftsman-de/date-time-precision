<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\Doctrine;

use DigitalCraftsman\DateTimeParts\ValueObject\Date;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateImmutableType;

final class DateType extends DateImmutableType
{
    /** @codeCoverageIgnore */
    public function getName(): string
    {
        return 'digital_craftsman_date';
    }

    /** @param Date|null $value */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        return $value->format($platform->getDateFormatString());
    }

    /** @param string|null $value */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Date
    {
        return $value === null
            ? null
            : Date::fromString($value);
    }
}
