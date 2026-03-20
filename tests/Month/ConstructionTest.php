<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Month;

use DigitalCraftsman\DateTimePrecision\Exception\InvalidMonth;
use DigitalCraftsman\DateTimePrecision\Month;
use DigitalCraftsman\DateTimePrecision\Year;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Month::class)]
#[CoversClass(InvalidMonth::class)]
final class ConstructionTest extends TestCase
{
    #[Test]
    public function construct_works(): void
    {
        // -- Arrange & Act
        $month = new Month(
            new Year(2022),
            10,
        );

        // -- Assert
        self::assertSame(10, $month->month);
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function construct_works_with_boundary_months(): void
    {
        // -- Act & Assert
        new Month(new Year(2022), 1);
        new Month(new Year(2022), 12);
    }

    #[Test]
    public function construct_fails_with_month_too_low(): void
    {
        // -- Assert
        $this->expectException(InvalidMonth::class);

        // -- Act
        new Month(new Year(2022), 0);
    }

    #[Test]
    public function construct_fails_with_month_too_high(): void
    {
        // -- Assert
        $this->expectException(InvalidMonth::class);

        // -- Act
        new Month(new Year(2022), 13);
    }

    #[Test]
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

    #[Test]
    public function from_string_works(): void
    {
        // -- Arrange
        $expectedMonth = Month::fromDateTime(new \DateTimeImmutable('2022-10-08 22:15:00'));

        // -- Act
        $month = Month::fromString('2022-10');

        // -- Assert
        self::assertTrue($expectedMonth->isEqualTo($month));
    }

    #[Test]
    public function from_string_fails(): void
    {
        // -- Assert
        $this->expectException(\InvalidArgumentException::class);

        // -- Arrange & Act
        Month::fromString('invalid date');
    }
}
