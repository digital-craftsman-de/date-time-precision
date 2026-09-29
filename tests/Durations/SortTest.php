<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Durations;

use DigitalCraftsman\DateTimePrecision\Duration;
use DigitalCraftsman\DateTimePrecision\Durations;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Durations::class)]
final class SortTest extends TestCase
{
    #[Test]
    public function sort_works_ascending_by_default(): void
    {
        // -- Arrange
        $collection = new Durations([
            Duration::fromMinutes(45),
            Duration::fromMinutes(15),
            Duration::fromMinutes(30),
        ]);

        // -- Act & Assert
        self::assertEquals(new Durations([
            Duration::fromMinutes(15),
            Duration::fromMinutes(30),
            Duration::fromMinutes(45),
        ]), $collection->sort());
    }

    #[Test]
    public function sort_works_with_comparator(): void
    {
        // -- Arrange
        $collection = new Durations([
            Duration::fromMinutes(45),
            Duration::fromMinutes(15),
            Duration::fromMinutes(30),
        ]);

        // -- Act & Assert
        self::assertEquals(new Durations([
            Duration::fromMinutes(45),
            Duration::fromMinutes(30),
            Duration::fromMinutes(15),
        ]), $collection->sort(static fn (Duration $x, Duration $y): int => $y->compareTo($x)));
    }

    #[Test]
    public function min_and_max_works(): void
    {
        // -- Arrange
        $collection = new Durations([
            Duration::fromMinutes(30),
            Duration::fromMinutes(45),
            Duration::fromMinutes(15),
        ]);

        // -- Act & Assert
        self::assertEquals(Duration::fromMinutes(15), $collection->min());
        self::assertEquals(Duration::fromMinutes(45), $collection->max());
        self::assertNull(new Durations([])->min());
        self::assertNull(new Durations([])->max());
    }
}
