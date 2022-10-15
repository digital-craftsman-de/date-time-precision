<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\DateTime */
final class DateTimeTest extends TestCase
{
    // -- Construction

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

    /**
     * @test
     *
     * @covers ::__toString
     */
    public function to_string_works(): void
    {
        // -- Arrange & Act
        $dateTime = DateTime::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin'));

        // -- Assert
        self::assertEquals('2022-10-08T13:00:00+00:00', (string) $dateTime);
    }

    // -- Mutations

    /**
     * @test
     *
     * @covers ::toUTC
     * @covers ::timezone
     */
    public function to_utc_works(): void
    {
        // -- Arrange
        $dateTime = new DateTime(new \DateTimeImmutable(
            '2022-10-07 14:39:24',
            new \DateTimeZone('Europe/Berlin'),
        ));

        // -- Act
        $dateTimeInUTC = $dateTime->toUTC();

        // -- Assert
        self::assertEquals(
            $dateTimeInUTC->timezone(),
            new \DateTimeZone('UTC'),
        );
        self::assertTrue(
            $dateTimeInUTC->time()->isEqualTo(Time::fromString('12:39:24')),
        );
    }
}
