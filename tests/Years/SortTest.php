<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Years;

use DigitalCraftsman\DateTimePrecision\Year;
use DigitalCraftsman\DateTimePrecision\Years;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Years::class)]
final class SortTest extends TestCase
{
    #[Test]
    public function sort_works_ascending_by_default(): void
    {
        // -- Arrange
        $collection = new Years([
            new Year(2026),
            new Year(2024),
            new Year(2025),
        ]);

        // -- Act & Assert
        self::assertEquals(new Years([
            new Year(2024),
            new Year(2025),
            new Year(2026),
        ]), $collection->sort());
    }

    #[Test]
    public function sort_works_with_comparator(): void
    {
        // -- Arrange
        $collection = new Years([
            new Year(2026),
            new Year(2024),
            new Year(2025),
        ]);

        // -- Act & Assert
        self::assertEquals(new Years([
            new Year(2026),
            new Year(2025),
            new Year(2024),
        ]), $collection->sort(static fn (Year $x, Year $y): int => $y->compareTo($x)));
    }

    #[Test]
    public function min_and_max_works(): void
    {
        // -- Arrange
        $collection = new Years([
            new Year(2025),
            new Year(2026),
            new Year(2024),
        ]);

        // -- Act & Assert
        self::assertEquals(new Year(2024), $collection->min());
        self::assertEquals(new Year(2026), $collection->max());
        self::assertNull(new Years([])->min());
        self::assertNull(new Years([])->max());
    }
}
