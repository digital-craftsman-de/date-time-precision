<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Year;

use DigitalCraftsman\DateTimePrecision\Year;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Year::class)]
final class ConstructionTest extends TestCase
{
    #[Test]
    public function construct_works(): void
    {
        // -- Arrange & Act
        $year = new Year(2022);

        // -- Assert
        self::assertSame(2022, $year->year);
    }

    #[Test]
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

    #[Test]
    public function from_string_works(): void
    {
        // -- Arrange
        $expectedYear = Year::fromDateTime(new \DateTimeImmutable('2022-10-08 22:15:00'));

        // -- Act
        $year = Year::fromString('2022');

        // -- Assert
        self::assertTrue($expectedYear->isEqualTo($year));
    }

    #[Test]
    public function from_string_fails(): void
    {
        // -- Assert
        $this->expectException(\InvalidArgumentException::class);

        // -- Arrange & Act
        Year::fromString('invalid date');
    }
}
