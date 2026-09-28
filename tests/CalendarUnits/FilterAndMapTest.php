<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\CalendarUnits;

use DigitalCraftsman\DateTimePrecision\CalendarUnit;
use DigitalCraftsman\DateTimePrecision\CalendarUnits;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(CalendarUnits::class)]
final class FilterAndMapTest extends TestCase
{
    #[Test]
    public function filter_works(): void
    {
        // -- Arrange
        $collection = new CalendarUnits([
            CalendarUnit::DAY,
            CalendarUnit::WEEK,
            CalendarUnit::MONTH,
        ]);
        $excluded = CalendarUnit::WEEK;

        // -- Act
        $filteredCollection = $collection->filter(static fn (CalendarUnit $value): bool => $value->normalize() !== $excluded->normalize());

        // -- Assert
        self::assertEquals(new CalendarUnits([
            CalendarUnit::DAY,
            CalendarUnit::MONTH,
        ]), $filteredCollection);
    }

    #[Test]
    public function map_works(): void
    {
        // -- Arrange
        $collection = new CalendarUnits([
            CalendarUnit::DAY,
            CalendarUnit::WEEK,
        ]);

        // -- Act & Assert
        self::assertSame(
            $collection->normalize(),
            $collection->map(static fn (CalendarUnit $value): mixed => $value->normalize()),
        );
        self::assertSame([], new CalendarUnits([])->map(static fn (CalendarUnit $value): mixed => $value->normalize()));
    }
}
