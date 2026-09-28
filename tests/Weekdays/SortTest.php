<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Weekdays;

use DigitalCraftsman\DateTimePrecision\Weekday;
use DigitalCraftsman\DateTimePrecision\Weekdays;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Weekdays::class)]
final class SortTest extends TestCase
{
    #[Test]
    public function sort_works_ascending_by_default(): void
    {
        // -- Arrange
        $collection = new Weekdays([
            Weekday::WEDNESDAY,
            Weekday::MONDAY,
            Weekday::TUESDAY,
        ]);

        // -- Act & Assert
        self::assertEquals(new Weekdays([
            Weekday::MONDAY,
            Weekday::TUESDAY,
            Weekday::WEDNESDAY,
        ]), $collection->sort());
    }

    #[Test]
    public function sort_works_with_comparator(): void
    {
        // -- Arrange
        $collection = new Weekdays([
            Weekday::WEDNESDAY,
            Weekday::MONDAY,
            Weekday::TUESDAY,
        ]);

        // -- Act & Assert
        self::assertEquals(new Weekdays([
            Weekday::WEDNESDAY,
            Weekday::TUESDAY,
            Weekday::MONDAY,
        ]), $collection->sort(static fn (Weekday $x, Weekday $y): int => $y->compareTo($x)));
    }

    #[Test]
    public function min_and_max_works(): void
    {
        // -- Arrange
        $collection = new Weekdays([
            Weekday::TUESDAY,
            Weekday::WEDNESDAY,
            Weekday::MONDAY,
        ]);

        // -- Act & Assert
        self::assertEquals(Weekday::MONDAY, $collection->min());
        self::assertEquals(Weekday::WEDNESDAY, $collection->max());
        self::assertNull(new Weekdays([])->min());
        self::assertNull(new Weekdays([])->max());
    }
}
