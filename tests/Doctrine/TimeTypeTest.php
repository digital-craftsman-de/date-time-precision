<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeUtils\Doctrine;

use DigitalCraftsman\DateTimeUtils\ValueObject\Time;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeUtils\Doctrine\TimeType */
final class TimeTypeTest extends TestCase
{
    /**
     * @test
     * @covers ::convertToDatabaseValue
     * @covers ::convertToPHPValue
     */
    public function convert_from_and_to_time_php_value_works(): void
    {
        // -- Arrange
        $time = Time::fromString('14:50:10');
        $timeType = new TimeType();
        $platform = new PostgreSQLPlatform();

        // -- Act
        $databaseValue = $timeType->convertToDatabaseValue($time, $platform);
        $phpValue = $timeType->convertToPHPValue($databaseValue, $platform);

        // -- Assert
        self::assertEquals($time, $phpValue);
    }

    /**
     * @test
     * @covers ::convertToDatabaseValue
     * @covers ::convertToPHPValue
     */
    public function convert_from_and_to_null_value_works(): void
    {
        // -- Arrange
        $timeType = new TimeType();
        $platform = new PostgreSQLPlatform();

        // -- Act
        $databaseValue = $timeType->convertToDatabaseValue(null, $platform);
        $phpValue = $timeType->convertToPHPValue($databaseValue, $platform);

        // -- Assert
        self::assertNull($phpValue);
    }
}
