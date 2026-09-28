<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Dates;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Dates;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Dates::class)]
final class SortTest extends TestCase
{
    #[Test]
    public function sort_works_ascending_by_default(): void
    {
        // -- Arrange
        $collection = new Dates([
            Date::fromString('2026-01-03'),
            Date::fromString('2026-01-01'),
            Date::fromString('2026-01-02'),
        ]);

        // -- Act & Assert
        self::assertEquals(new Dates([
            Date::fromString('2026-01-01'),
            Date::fromString('2026-01-02'),
            Date::fromString('2026-01-03'),
        ]), $collection->sort());
    }

    #[Test]
    public function sort_works_with_comparator(): void
    {
        // -- Arrange
        $collection = new Dates([
            Date::fromString('2026-01-03'),
            Date::fromString('2026-01-01'),
            Date::fromString('2026-01-02'),
        ]);

        // -- Act & Assert
        self::assertEquals(new Dates([
            Date::fromString('2026-01-03'),
            Date::fromString('2026-01-02'),
            Date::fromString('2026-01-01'),
        ]), $collection->sort(static fn (Date $x, Date $y): int => $y->compareTo($x)));
    }

    #[Test]
    public function min_and_max_works(): void
    {
        // -- Arrange
        $collection = new Dates([
            Date::fromString('2026-01-02'),
            Date::fromString('2026-01-03'),
            Date::fromString('2026-01-01'),
        ]);

        // -- Act & Assert
        self::assertEquals(Date::fromString('2026-01-01'), $collection->min());
        self::assertEquals(Date::fromString('2026-01-03'), $collection->max());
        self::assertNull(new Dates([])->min());
        self::assertNull(new Dates([])->max());
    }
}
