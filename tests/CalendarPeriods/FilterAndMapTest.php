<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\CalendarPeriods;

use DigitalCraftsman\DateTimePrecision\CalendarPeriod;
use DigitalCraftsman\DateTimePrecision\CalendarPeriods;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(CalendarPeriods::class)]
final class FilterAndMapTest extends TestCase
{
    #[Test]
    public function filter_works(): void
    {
        // -- Arrange
        $collection = new CalendarPeriods([
            CalendarPeriod::weeks(1),
            CalendarPeriod::days(7),
            CalendarPeriod::days(1),
        ]);
        $excluded = CalendarPeriod::days(7);

        // -- Act
        $filteredCollection = $collection->filter(static fn (CalendarPeriod $value): bool => $value->normalize() !== $excluded->normalize());

        // -- Assert
        self::assertEquals(new CalendarPeriods([
            CalendarPeriod::weeks(1),
            CalendarPeriod::days(1),
        ]), $filteredCollection);
    }

    #[Test]
    public function map_works(): void
    {
        // -- Arrange
        $collection = new CalendarPeriods([
            CalendarPeriod::weeks(1),
            CalendarPeriod::days(7),
        ]);

        // -- Act & Assert
        self::assertSame(
            $collection->normalize(),
            $collection->map(static fn (CalendarPeriod $value): mixed => $value->normalize()),
        );
        self::assertSame([], new CalendarPeriods([])->map(static fn (CalendarPeriod $value): mixed => $value->normalize()));
    }
}
