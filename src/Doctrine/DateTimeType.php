<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeUtils\Doctrine;

use DigitalCraftsman\DateTimeUtils\ValueObject\DateTime;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeImmutableType;

final class DateTimeType extends DateTimeImmutableType
{
    public const NAME = 'digital_craftsman_date_time';

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return self::NAME;
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
        if ($value === null || $value instanceof DateTime) {
            return $value;
        }

        return DateTime::fromString($value);
    }
}
