<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\ValueObject;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\ValueObject\Year */
final class YearTest extends TestCase
{
    /**
     * @test
     *
     * @covers ::__construct
     */
    public function construct_works(): void
    {
        // -- Arrange & Act
        $year = new Year(2022);

        // -- Assert
        self::assertSame(2022, $year->year);
    }

    /**
     * @test
     *
     * @covers ::fromDateTime
     */
    public function from_date_time_works(): void
    {
        // -- Arrange
        $expectedYear = new Year(2022);
        $dateTimeImmutable = new \DateTimeImmutable('2022-10-08 22:15:00');

        // -- Act
        $year = Year::fromDateTime($dateTimeImmutable);

        // -- Assert
        self::assertTrue($expectedYear->isEqualTo($year));
    }

    /**
     * @test
     *
     * @covers ::fromString
     */
    public function from_string_works(): void
    {
        // -- Arrange
        $expectedYear = Year::fromDateTime(new \DateTimeImmutable('2022-10-08 22:15:00'));

        // -- Act
        $year = Year::fromString('2022');

        // -- Assert
        self::assertTrue($expectedYear->isEqualTo($year));
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
        Year::fromString('invalid date');
    }
}
