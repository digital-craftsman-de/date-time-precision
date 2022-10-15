<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\Month */
final class MonthTest extends TestCase
{
    /**
     * @test
     *
     * @covers ::__construct
     */
    public function construct_works(): void
    {
        // -- Arrange & Act
        $month = new Month(
            new Year(2022),
            10,
        );

        // -- Assert
        self::assertSame(10, $month->monthOfYear);
    }

    /**
     * @test
     *
     * @covers ::fromDateTime
     */
    public function from_date_time_works(): void
    {
        // -- Arrange
        $expectedMonth = Month::fromString('2022-10');
        $dateTimeImmutable = new \DateTimeImmutable('2022-10-08 22:15:00');

        // -- Act
        $month = Month::fromDateTime($dateTimeImmutable);

        // -- Assert
        self::assertTrue($expectedMonth->isEqualTo($month));
    }

    /**
     * @test
     *
     * @covers ::fromString
     */
    public function from_string_works(): void
    {
        // -- Arrange
        $expectedMonth = Month::fromDateTime(new \DateTimeImmutable('2022-10-08 22:15:00'));

        // -- Act
        $month = Month::fromString('2022-10');

        // -- Assert
        self::assertTrue($expectedMonth->isEqualTo($month));
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
        Month::fromString('invalid date');
    }

    /**
     * @test
     *
     * @covers ::__toString
     */
    public function to_string_works(): void
    {
        // -- Arrange & Act
        $month = Month::fromString('2022-10');

        // -- Assert
        self::assertEquals('2022-10', (string) $month);
    }
}
