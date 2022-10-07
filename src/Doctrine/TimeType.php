<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeUtils\Doctrine;

use DigitalCraftsman\DateTimeUtils\ValueObject\Time;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\TimeImmutableType;

final class TimeType extends TimeImmutableType
{
    /** @codeCoverageIgnore */
    public function getName(): string
    {
        return 'digital_craftsman_time';
    }

    /** @param Time|null $value */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        return $value->format($platform->getTimeFormatString());
    }

    /** @param string|null $value */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Time
    {
        if ($value === null || $value instanceof Time) {
            return $value;
        }

        return Time::fromString($value);
    }
}
