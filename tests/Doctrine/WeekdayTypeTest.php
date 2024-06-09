<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Doctrine;

use DigitalCraftsman\DateTimePrecision\Weekday;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Doctrine\WeekdayType */
final class WeekdayTypeTest extends TestCase
{
    /**
     * @test
     *
     * @covers ::convertToDatabaseValue
     * @covers ::convertToPHPValue
     */
    public function convert_from_and_to_month_php_value_works(): void
    {
        // -- Arrange
        $weekday = Weekday::MONDAY;
        $weekdayType = new WeekdayType();
        $platform = new PostgreSQLPlatform();

        // -- Act
        $databaseValue = $weekdayType->convertToDatabaseValue($weekday, $platform);
        $phpValue = $weekdayType->convertToPHPValue($databaseValue, $platform);

        // -- Assert
        self::assertEquals($weekday, $phpValue);
    }

    /**
     * @test
     *
     * @covers ::convertToDatabaseValue
     * @covers ::convertToPHPValue
     */
    public function convert_from_and_to_null_value_works(): void
    {
        // -- Arrange
        $weekdayType = new WeekdayType();
        $platform = new PostgreSQLPlatform();

        // -- Act
        $databaseValue = $weekdayType->convertToDatabaseValue(null, $platform);
        $phpValue = $weekdayType->convertToPHPValue($databaseValue, $platform);

        // -- Assert
        self::assertNull($phpValue);
    }
}
