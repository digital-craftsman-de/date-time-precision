<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\Doctrine;

use DigitalCraftsman\DateTimeParts\DateTime;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeImmutableType;

final class DateTimeType extends DateTimeImmutableType
{
    /** @codeCoverageIgnore */
    public function getName(): string
    {
        return 'digital_craftsman_date_time';
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
}
