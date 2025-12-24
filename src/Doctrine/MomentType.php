<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Doctrine;

use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\SelfAwareNormalizers\Doctrine\StringNormalizableType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\MySQLPlatform;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;

/**
 * @codeCoverageIgnore
 */
final class MomentType extends StringNormalizableType
{
    #[\Override]
    public static function getTypeName(): string
    {
        return 'dtp_moment';
    }

    #[\Override]
    public static function getClass(): string
    {
        return Moment::class;
    }

    #[\Override]
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
}
