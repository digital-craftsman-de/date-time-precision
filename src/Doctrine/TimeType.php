<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\Doctrine;

use DigitalCraftsman\DateTimeParts\Time;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class TimeType extends Type
{
    /** @codeCoverageIgnore */
    public function getName(): string
    {
        return 'digital_craftsman_time';
    }

    /** @codeCoverageIgnore */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getTimeTypeDeclarationSQL($column);
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
        return $value === null
            ? null
            : Time::fromString($value);
    }

    /** @codeCoverageIgnore */
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
