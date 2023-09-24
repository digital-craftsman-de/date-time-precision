<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Month;
use DigitalCraftsman\DateTimePrecision\Year;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Date */
final class ConstructionTest extends TestCase
{
    /**
     * @test
     *
     * @covers ::__construct
     */
    public function construct_works(): void
    {
        // -- Arrange & Act
        $date = new Date(
            new Month(
                new Year(2022),
                10,
            ),
            8,
        );

        // -- Assert
        self::assertSame(8, $date->day);
    }

    /**
     * @test
     *
     * @covers ::fromDateTime
     */
    public function from_date_time_works(): void
    {
        // -- Arrange
        $expectedDate = Date::fromString('2022-10-08');
        $dateTimeImmutable = new \DateTimeImmutable('2022-10-08 22:15:00');

        // -- Act
        $date = Date::fromDateTime($dateTimeImmutable);

        // -- Assert
        self::assertTrue($expectedDate->isEqualTo($date));
    }

    /**
     * @test
     *
     * @covers ::fromString
     */
    public function from_string_works(): void
    {
        // -- Arrange
        $expectedDate = Date::fromDateTime(new \DateTimeImmutable('2022-10-08 22:15:00'));

        // -- Act
        $date = Date::fromString('2022-10-08');

        // -- Assert
        self::assertTrue($expectedDate->isEqualTo($date));
    }

    /**
     * @test
     *
     * @covers ::fromString
     */
    public function from_string_fails(): void
    {
        // -- Assert
        $this->expectException(\InvalidArgumentException::class);

        // -- Arrange & Act
        Date::fromString('invalid date');
    }
}
