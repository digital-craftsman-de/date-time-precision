<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Days;

use DigitalCraftsman\DateTimePrecision\Day;
use DigitalCraftsman\DateTimePrecision\Days;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Days::class)]
final class SortTest extends TestCase
{
    #[Test]
    public function sort_works_ascending_by_default(): void
    {
        // -- Arrange
        $collection = new Days([
            new Day(31),
            new Day(1),
            new Day(15),
        ]);

        // -- Act & Assert
        self::assertEquals(new Days([
            new Day(1),
            new Day(15),
            new Day(31),
        ]), $collection->sort());
    }

    #[Test]
    public function sort_works_with_comparator(): void
    {
        // -- Arrange
        $collection = new Days([
            new Day(31),
            new Day(1),
            new Day(15),
        ]);

        // -- Act & Assert
        self::assertEquals(new Days([
            new Day(31),
            new Day(15),
            new Day(1),
        ]), $collection->sort(static fn (Day $x, Day $y): int => $y->day <=> $x->day));
    }

    #[Test]
    public function min_and_max_works(): void
    {
        // -- Arrange
        $collection = new Days([
            new Day(15),
            new Day(31),
            new Day(1),
        ]);

        // -- Act & Assert
        self::assertEquals(new Day(1), $collection->min());
        self::assertEquals(new Day(31), $collection->max());
        self::assertNull(new Days([])->min());
        self::assertNull(new Days([])->max());
    }
}
