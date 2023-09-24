<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Doctrine;

use DigitalCraftsman\DateTimePrecision\Moment;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\MySQLPlatform;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Types\Type;

final class MomentType extends Type
{
    /** @codeCoverageIgnore */
    public function getName(): string
    {
        return 'dtp_moment';
    }

    /** @codeCoverageIgnore */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        if ($platform instanceof PostgreSQLPlatform) {
            return 'TIMESTAMP(6)';
        }

        if ($platform instanceof MySQLPlatform) {
            return 'DATETIME(6)';
        }

        throw new \RuntimeException('Unsupported platform');
    }

    /** @param Moment|null $value */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        return $value->format('Y-m-d H:i:s.u');
    }

    /** @param string|null $value */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Moment
    {
        return $value === null
            ? null
            : Moment::fromString($value);
    }

    /** @codeCoverageIgnore */
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
