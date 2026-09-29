<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\CalendarPeriods;

use DigitalCraftsman\DateTimePrecision\CalendarPeriod;
use DigitalCraftsman\DateTimePrecision\CalendarPeriods;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(CalendarPeriods::class)]
final class ContainsTest extends TestCase
{
    #[Test]
    public function contains_works(): void
    {
        // -- Arrange
        $collection = new CalendarPeriods([
            CalendarPeriod::weeks(1),
            CalendarPeriod::days(7),
        ]);

        // -- Act & Assert
        self::assertTrue($collection->contains(CalendarPeriod::weeks(1)));
        self::assertTrue($collection->contains(CalendarPeriod::days(7)));
        self::assertFalse($collection->contains(CalendarPeriod::days(1)));
        self::assertFalse(new CalendarPeriods([])->contains(CalendarPeriod::weeks(1)));
    }

    #[Test]
    public function not_contains_works(): void
    {
        // -- Arrange
        $collection = new CalendarPeriods([
            CalendarPeriod::weeks(1),
            CalendarPeriod::days(7),
        ]);

        // -- Act & Assert
        self::assertFalse($collection->notContains(CalendarPeriod::weeks(1)));
        self::assertTrue($collection->notContains(CalendarPeriod::days(1)));
    }
}
