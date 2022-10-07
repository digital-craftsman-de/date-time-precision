<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeUtils\Doctrine;

use DigitalCraftsman\DateTimeUtils\ValueObject\Date;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use PHPUnit\Framework\TestCase;

final class DateTypeTest extends TestCase
{
    /** @test */
    public function convert_from_and_to_date_php_value_works(): void
    {
        // -- Arrange
        $date = Date::fromString('2022-10-07');
        $dateType = new DateType();
        $platform = new PostgreSQLPlatform();

        // -- Act
        $databaseValue = $dateType->convertToDatabaseValue($date, $platform);
        $phpValue = $dateType->convertToPHPValue($databaseValue, $platform);

        // -- Assert
        self::assertEquals($date, $phpValue);
    }

    /** @test */
    public function convert_from_and_to_null_value_works(): void
    {
        // -- Arrange
        $dateType = new DateType();
        $platform = new PostgreSQLPlatform();

        // -- Act
        $databaseValue = $dateType->convertToDatabaseValue(null, $platform);
        $phpValue = $dateType->convertToPHPValue($databaseValue, $platform);

        // -- Assert
        self::assertNull($phpValue);
    }
}
