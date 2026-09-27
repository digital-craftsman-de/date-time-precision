<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\DateRange;

use DigitalCraftsman\DateTimePrecision\CalendarPeriod;
use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\DateRange;
use DigitalCraftsman\DateTimePrecision\Exception\DateRangeStartIsAfterEnd;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(DateRange::class)]
#[CoversClass(DateRangeStartIsAfterEnd::class)]
final class ShiftTest extends TestCase
{
    #[Test]
    public function shift_forward_works(): void
    {
        // -- Arrange
        $dateRange = new DateRange(Date::fromString('2026-01-10'), Date::fromString('2026-01-20'));

        // -- Act & Assert
        self::assertEquals(
            new DateRange(Date::fromString('2026-01-17'), Date::fromString('2026-01-27')),
            $dateRange->shiftForward(CalendarPeriod::weeks(1)),
        );
    }

    #[Test]
    public function shift_backward_works(): void
    {
        // -- Arrange
        $dateRange = new DateRange(Date::fromString('2026-01-10'), Date::fromString('2026-01-20'));

        // -- Act & Assert
        self::assertEquals(
            new DateRange(Date::fromString('2025-12-10'), Date::fromString('2025-12-20')),
            $dateRange->shiftBackward(CalendarPeriod::months(1)),
        );
    }

    #[Test]
    public function shift_forward_fails_when_native_overflow_moves_start_after_end(): void
    {
        // -- Arrange
        $dateRange = new DateRange(Date::fromString('2026-01-31'), Date::fromString('2026-02-01'));

        // -- Assert
        $this->expectException(DateRangeStartIsAfterEnd::class);

        // -- Act
        $dateRange->shiftForward(CalendarPeriod::months(1));
    }
}
