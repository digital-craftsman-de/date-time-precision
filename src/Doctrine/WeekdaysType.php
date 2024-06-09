<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Doctrine;

use DigitalCraftsman\DateTimePrecision\Weekdays;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;

final class WeekdaysType extends JsonType
{
    /** @codeCoverageIgnore */
    public function getName(): string
    {
        return 'dtp_weekdays';
    }

    /** @param Weekdays|null $value */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        $array = $value->normalize();

        return json_encode($array, JSON_THROW_ON_ERROR);
    }

    /** @param string|null $value */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Weekdays
    {
        if ($value === null) {
            return null;
        }

        $array = json_decode($value, true, 512, JSON_THROW_ON_ERROR);

        return Weekdays::denormalize($array);
    }

    /** @codeCoverageIgnore */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $column['jsonb'] = true;

        return $platform->getJsonTypeDeclarationSQL($column);
    }

    /** @codeCoverageIgnore */
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
