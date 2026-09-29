<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\CalendarPeriods;

use DigitalCraftsman\DateTimePrecision\CalendarPeriod;
use DigitalCraftsman\DateTimePrecision\CalendarPeriods;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(CalendarPeriods::class)]
final class SortTest extends TestCase
{
    #[Test]
    public function sort_works_with_comparator(): void
    {
        // -- Arrange
        $collection = new CalendarPeriods([
            CalendarPeriod::days(7),
            CalendarPeriod::weeks(1),
            CalendarPeriod::days(1),
        ]);

        // -- Act & Assert
        self::assertEquals(new CalendarPeriods([
            CalendarPeriod::days(1),
            CalendarPeriod::weeks(1),
            CalendarPeriod::days(7),
        ]), $collection->sort(static fn (CalendarPeriod $x, CalendarPeriod $y): int => ($x->amount <=> $y->amount) ?: strcmp($x->unit->value, $y->unit->value)));
    }
}
