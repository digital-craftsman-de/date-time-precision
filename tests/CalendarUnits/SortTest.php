<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\CalendarUnits;

use DigitalCraftsman\DateTimePrecision\CalendarUnit;
use DigitalCraftsman\DateTimePrecision\CalendarUnits;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(CalendarUnits::class)]
final class SortTest extends TestCase
{
    #[Test]
    public function sort_works_with_comparator(): void
    {
        // -- Arrange
        $collection = new CalendarUnits([
            CalendarUnit::WEEK,
            CalendarUnit::MONTH,
            CalendarUnit::DAY,
        ]);

        // -- Act & Assert
        self::assertEquals(new CalendarUnits([
            CalendarUnit::DAY,
            CalendarUnit::MONTH,
            CalendarUnit::WEEK,
        ]), $collection->sort(static fn (CalendarUnit $x, CalendarUnit $y): int => strcmp($x->value, $y->value)));
    }
}
