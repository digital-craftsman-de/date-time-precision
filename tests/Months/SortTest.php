<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Months;

use DigitalCraftsman\DateTimePrecision\Month;
use DigitalCraftsman\DateTimePrecision\Months;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Months::class)]
final class SortTest extends TestCase
{
    #[Test]
    public function sort_works_ascending_by_default(): void
    {
        // -- Arrange
        $collection = new Months([
            Month::fromString('2026-03'),
            Month::fromString('2026-01'),
            Month::fromString('2026-02'),
        ]);

        // -- Act & Assert
        self::assertEquals(new Months([
            Month::fromString('2026-01'),
            Month::fromString('2026-02'),
            Month::fromString('2026-03'),
        ]), $collection->sort());
    }

    #[Test]
    public function sort_works_with_comparator(): void
    {
        // -- Arrange
        $collection = new Months([
            Month::fromString('2026-03'),
            Month::fromString('2026-01'),
            Month::fromString('2026-02'),
        ]);

        // -- Act & Assert
        self::assertEquals(new Months([
            Month::fromString('2026-03'),
            Month::fromString('2026-02'),
            Month::fromString('2026-01'),
        ]), $collection->sort(static fn (Month $x, Month $y): int => $y->compareTo($x)));
    }

    #[Test]
    public function min_and_max_works(): void
    {
        // -- Arrange
        $collection = new Months([
            Month::fromString('2026-02'),
            Month::fromString('2026-03'),
            Month::fromString('2026-01'),
        ]);

        // -- Act & Assert
        self::assertEquals(Month::fromString('2026-01'), $collection->min());
        self::assertEquals(Month::fromString('2026-03'), $collection->max());
        self::assertNull(new Months([])->min());
        self::assertNull(new Months([])->max());
    }
}
