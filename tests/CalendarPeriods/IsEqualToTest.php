<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\CalendarPeriods;

use DigitalCraftsman\DateTimePrecision\CalendarPeriod;
use DigitalCraftsman\DateTimePrecision\CalendarPeriods;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(CalendarPeriods::class)]
final class IsEqualToTest extends TestCase
{
    #[Test]
    public function is_equal_to_works(): void
    {
        // -- Arrange
        $collection = new CalendarPeriods([
            CalendarPeriod::weeks(1),
            CalendarPeriod::days(7),
        ]);

        // -- Act & Assert
        self::assertTrue($collection->isEqualTo(new CalendarPeriods([
            CalendarPeriod::weeks(1),
            CalendarPeriod::days(7),
        ])));
        self::assertTrue($collection->isEqualTo(new CalendarPeriods([
            CalendarPeriod::days(7),
            CalendarPeriod::weeks(1),
        ])));
        self::assertFalse($collection->isEqualTo(new CalendarPeriods([
            CalendarPeriod::weeks(1),
        ])));
        self::assertFalse(new CalendarPeriods([
            CalendarPeriod::weeks(1),
        ])->isEqualTo($collection));
        self::assertFalse($collection->isEqualTo(new CalendarPeriods([
            CalendarPeriod::weeks(1),
            CalendarPeriod::days(1),
        ])));
        self::assertTrue(new CalendarPeriods([])->isEqualTo(new CalendarPeriods([])));
    }

    #[Test]
    public function is_not_equal_to_works(): void
    {
        // -- Arrange
        $collection = new CalendarPeriods([
            CalendarPeriod::weeks(1),
            CalendarPeriod::days(7),
        ]);

        // -- Act & Assert
        self::assertFalse($collection->isNotEqualTo(new CalendarPeriods([
            CalendarPeriod::days(7),
            CalendarPeriod::weeks(1),
        ])));
        self::assertTrue($collection->isNotEqualTo(new CalendarPeriods([
            CalendarPeriod::weeks(1),
            CalendarPeriod::days(1),
        ])));
    }
}
