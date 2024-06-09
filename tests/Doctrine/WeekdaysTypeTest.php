<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Doctrine;

use DigitalCraftsman\DateTimePrecision\Weekday;
use DigitalCraftsman\DateTimePrecision\Weekdays;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Doctrine\WeekdaysType */
final class WeekdaysTypeTest extends TestCase
{
    /**
     * @test
     *
     * @covers ::convertToDatabaseValue
     * @covers ::convertToPHPValue
     */
    public function convert_from_and_to_weekdays_php_value_works(): void
    {
        // -- Arrange
        $doctrineType = new WeekdaysType();
        $platform = new PostgreSQLPlatform();

        $weekdays = new Weekdays([
            Weekday::MONDAY,
            Weekday::TUESDAY,
        ]);

        $expectedDatabaseValue = '["MONDAY","TUESDAY"]';

        // -- Act
        $databaseValue = $doctrineType->convertToDatabaseValue($weekdays, $platform);
        $convertedValue = $doctrineType->convertToPHPValue($databaseValue, $platform);

        // -- Assert
        self::assertSame($expectedDatabaseValue, $databaseValue);
        self::assertEquals($weekdays, $convertedValue);
    }

    /**
     * @test
     *
     * @covers ::convertToDatabaseValue
     * @covers ::convertToPHPValue
     */
    public function convert_from_and_to_weekdays_php_value_works_with_null(): void
    {
        // -- Arrange
        $doctrineType = new WeekdaysType();
        $platform = new PostgreSQLPlatform();

        // -- Act
        $databaseValue = $doctrineType->convertToDatabaseValue(null, $platform);
        $phpValue = $doctrineType->convertToPHPValue($databaseValue, $platform);

        // -- Assert
        self::assertNull($phpValue);
    }
}
