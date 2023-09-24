<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\DateTime;

use DigitalCraftsman\DateTimePrecision\DateTime;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\DateTime */
final class ConstructionTest extends TestCase
{
    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::fromDateTime
     */
    public function construction_with_date_time_works(): void
    {
        // -- Arrange
        $dateTimeImmutable = new \DateTimeImmutable('now');

        // -- Act
        $dateTime = DateTime::fromDateTime($dateTimeImmutable);

        // -- Assert
        self::assertSame($dateTimeImmutable, $dateTime->dateTime);
    }

    /**
     * @test
     *
     * @covers ::fromString
     */
    public function from_string_works(): void
    {
        // -- Arrange & Act
        $dateTime = DateTime::fromString('2022-10-08 15:00:00');

        // -- Assert
        self::assertEquals(new \DateTimeImmutable('2022-10-08 15:00:00'), $dateTime->dateTime);
    }

    /**
     * @test
     *
     * @covers ::fromStringInTimeZone
     */
    public function from_string_in_time_zone_works(): void
    {
        // -- Arrange & Act
        $dateTime = DateTime::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin'));

        // -- Assert
        self::assertEquals(new \DateTimeImmutable('2022-10-08 13:00:00'), $dateTime->dateTime);
    }
}
