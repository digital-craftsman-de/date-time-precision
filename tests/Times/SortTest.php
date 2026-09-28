<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Times;

use DigitalCraftsman\DateTimePrecision\Time;
use DigitalCraftsman\DateTimePrecision\Times;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Times::class)]
final class SortTest extends TestCase
{
    #[Test]
    public function sort_works_ascending_by_default(): void
    {
        // -- Arrange
        $collection = new Times([
            new Time(12, 0, 0),
            new Time(10, 0, 0),
            new Time(11, 0, 0),
        ]);

        // -- Act & Assert
        self::assertEquals(new Times([
            new Time(10, 0, 0),
            new Time(11, 0, 0),
            new Time(12, 0, 0),
        ]), $collection->sort());
    }

    #[Test]
    public function sort_works_with_comparator(): void
    {
        // -- Arrange
        $collection = new Times([
            new Time(12, 0, 0),
            new Time(10, 0, 0),
            new Time(11, 0, 0),
        ]);

        // -- Act & Assert
        self::assertEquals(new Times([
            new Time(12, 0, 0),
            new Time(11, 0, 0),
            new Time(10, 0, 0),
        ]), $collection->sort(static fn (Time $x, Time $y): int => $y->compareTo($x)));
    }

    #[Test]
    public function min_and_max_works(): void
    {
        // -- Arrange
        $collection = new Times([
            new Time(11, 0, 0),
            new Time(12, 0, 0),
            new Time(10, 0, 0),
        ]);

        // -- Act & Assert
        self::assertEquals(new Time(10, 0, 0), $collection->min());
        self::assertEquals(new Time(12, 0, 0), $collection->max());
        self::assertNull(new Times([])->min());
        self::assertNull(new Times([])->max());
    }
}
