<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Weeks;

use DigitalCraftsman\DateTimePrecision\Week;
use DigitalCraftsman\DateTimePrecision\Weeks;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Weeks::class)]
final class SortTest extends TestCase
{
    #[Test]
    public function sort_works_ascending_by_default(): void
    {
        // -- Arrange
        $collection = new Weeks([
            Week::fromString('2026-W03'),
            Week::fromString('2026-W01'),
            Week::fromString('2026-W02'),
        ]);

        // -- Act & Assert
        self::assertEquals(new Weeks([
            Week::fromString('2026-W01'),
            Week::fromString('2026-W02'),
            Week::fromString('2026-W03'),
        ]), $collection->sort());
    }

    #[Test]
    public function sort_works_with_comparator(): void
    {
        // -- Arrange
        $collection = new Weeks([
            Week::fromString('2026-W03'),
            Week::fromString('2026-W01'),
            Week::fromString('2026-W02'),
        ]);

        // -- Act & Assert
        self::assertEquals(new Weeks([
            Week::fromString('2026-W03'),
            Week::fromString('2026-W02'),
            Week::fromString('2026-W01'),
        ]), $collection->sort(static fn (Week $x, Week $y): int => $y->compareTo($x)));
    }

    #[Test]
    public function min_and_max_works(): void
    {
        // -- Arrange
        $collection = new Weeks([
            Week::fromString('2026-W02'),
            Week::fromString('2026-W03'),
            Week::fromString('2026-W01'),
        ]);

        // -- Act & Assert
        self::assertEquals(Week::fromString('2026-W01'), $collection->min());
        self::assertEquals(Week::fromString('2026-W03'), $collection->max());
        self::assertNull(new Weeks([])->min());
        self::assertNull(new Weeks([])->max());
    }
}
