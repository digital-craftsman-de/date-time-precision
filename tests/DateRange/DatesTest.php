<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\DateRange;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\DateRange;
use DigitalCraftsman\DateTimePrecision\PeriodLimit;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(DateRange::class)]
final class DatesTest extends TestCase
{
    #[Test]
    public function dates_works(): void
    {
        // -- Arrange
        $dateRange = new DateRange(Date::fromString('2026-01-30'), Date::fromString('2026-02-02'));

        // -- Act & Assert
        self::assertEquals([
            Date::fromString('2026-01-30'),
            Date::fromString('2026-01-31'),
            Date::fromString('2026-02-01'),
            Date::fromString('2026-02-02'),
        ], $dateRange->dates());
        self::assertEquals([
            Date::fromString('2026-01-31'),
            Date::fromString('2026-02-01'),
        ], $dateRange->dates(PeriodLimit::EXCLUDING_START_AND_END));
    }

    #[Test]
    public function number_of_days_works(): void
    {
        // -- Act & Assert
        self::assertSame(1, new DateRange(Date::fromString('2026-01-30'), Date::fromString('2026-01-30'))->numberOfDays());
        self::assertSame(4, new DateRange(Date::fromString('2026-01-30'), Date::fromString('2026-02-02'))->numberOfDays());
        self::assertSame(366, new DateRange(Date::fromString('2024-01-01'), Date::fromString('2024-12-31'))->numberOfDays());
    }
}
