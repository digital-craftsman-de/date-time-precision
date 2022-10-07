<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\Doctrine;

use DigitalCraftsman\DateTimeParts\ValueObject\Month;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\ValueObject\Month */
final class MonthTypeTest extends TestCase
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
        $month = Month::fromString('2022-09');
        $monthType = new MonthType();
        $platform = new PostgreSQLPlatform();

        // -- Act
        $databaseValue = $monthType->convertToDatabaseValue($month, $platform);
        $phpValue = $monthType->convertToPHPValue($databaseValue, $platform);

        // -- Assert
        self::assertEquals($month, $phpValue);
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
        $monthType = new MonthType();
        $platform = new PostgreSQLPlatform();

        // -- Act
        $databaseValue = $monthType->convertToDatabaseValue(null, $platform);
        $phpValue = $monthType->convertToPHPValue($databaseValue, $platform);

        // -- Assert
        self::assertNull($phpValue);
    }
}
