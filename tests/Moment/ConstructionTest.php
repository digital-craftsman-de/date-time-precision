<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Moment */
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
        $dateTime = Moment::fromDateTime($dateTimeImmutable);

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
        $dateTime = Moment::fromString('2022-10-08 15:00:00');

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
        $dateTime = Moment::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin'));

        // -- Assert
        self::assertEquals(new \DateTimeImmutable('2022-10-08 13:00:00'), $dateTime->dateTime);
    }
}
