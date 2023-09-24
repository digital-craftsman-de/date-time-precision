<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Doctrine;

use DigitalCraftsman\DateTimePrecision\Year;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Doctrine\YearType */
final class YearTypeTest extends TestCase
{
    /**
     * @test
     *
     * @covers ::convertToDatabaseValue
     * @covers ::convertToPHPValue
     */
    public function convert_from_and_to_year_php_value_works(): void
    {
        // -- Arrange
        $year = new Year(2022);
        $yearType = new YearType();
        $platform = new PostgreSQLPlatform();

        // -- Act
        $databaseValue = $yearType->convertToDatabaseValue($year, $platform);
        $phpValue = $yearType->convertToPHPValue($databaseValue, $platform);

        // -- Assert
        self::assertEquals($year, $phpValue);
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
        $yearType = new YearType();
        $platform = new PostgreSQLPlatform();

        // -- Act
        $databaseValue = $yearType->convertToDatabaseValue(null, $platform);
        $phpValue = $yearType->convertToPHPValue($databaseValue, $platform);

        // -- Assert
        self::assertNull($phpValue);
    }
}
