<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\Date */
final class DateTest extends TestCase
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
        self::assertSame(8, $date->dayOfMonth);
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

    /**
     * @test
     *
     * @covers ::__toString
     */
    public function to_string_works(): void
    {
        // -- Arrange & Act
        $date = Date::fromString('2022-10-08');

        // -- Assert
        self::assertEquals('2022-10-08', (string) $date);
    }
}
