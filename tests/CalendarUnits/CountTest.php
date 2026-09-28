<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\CalendarUnits;

use DigitalCraftsman\DateTimePrecision\CalendarUnit;
use DigitalCraftsman\DateTimePrecision\CalendarUnits;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(CalendarUnits::class)]
final class CountTest extends TestCase
{
    #[Test]
    public function count_and_iteration_works(): void
    {
        // -- Arrange
        $collection = new CalendarUnits([
            CalendarUnit::DAY,
            CalendarUnit::WEEK,
        ]);

        // -- Act & Assert
        self::assertCount(2, $collection);
        self::assertSame(2, $collection->count());
        self::assertEquals([
            CalendarUnit::DAY,
            CalendarUnit::WEEK,
        ], iterator_to_array($collection));
        self::assertFalse($collection->isEmpty());
        self::assertTrue($collection->isNotEmpty());
    }

    #[Test]
    public function count_and_iteration_works_without_elements(): void
    {
        // -- Arrange
        $collection = new CalendarUnits([]);

        // -- Act & Assert
        self::assertCount(0, $collection);
        self::assertSame([], iterator_to_array($collection));
        self::assertTrue($collection->isEmpty());
        self::assertFalse($collection->isNotEmpty());
    }
}
