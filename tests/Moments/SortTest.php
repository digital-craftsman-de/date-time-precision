<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moments;

use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\Moments;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Moments::class)]
final class SortTest extends TestCase
{
    #[Test]
    public function sort_works_ascending_by_default(): void
    {
        // -- Arrange
        $collection = new Moments([
            Moment::fromString('2026-01-01 12:00:00'),
            Moment::fromString('2026-01-01 10:00:00'),
            Moment::fromString('2026-01-01 11:00:00'),
        ]);

        // -- Act & Assert
        self::assertEquals(new Moments([
            Moment::fromString('2026-01-01 10:00:00'),
            Moment::fromString('2026-01-01 11:00:00'),
            Moment::fromString('2026-01-01 12:00:00'),
        ]), $collection->sort());
    }

    #[Test]
    public function sort_works_with_comparator(): void
    {
        // -- Arrange
        $collection = new Moments([
            Moment::fromString('2026-01-01 12:00:00'),
            Moment::fromString('2026-01-01 10:00:00'),
            Moment::fromString('2026-01-01 11:00:00'),
        ]);

        // -- Act & Assert
        self::assertEquals(new Moments([
            Moment::fromString('2026-01-01 12:00:00'),
            Moment::fromString('2026-01-01 11:00:00'),
            Moment::fromString('2026-01-01 10:00:00'),
        ]), $collection->sort(static fn (Moment $x, Moment $y): int => $y->compareTo($x)));
    }

    #[Test]
    public function min_and_max_works(): void
    {
        // -- Arrange
        $collection = new Moments([
            Moment::fromString('2026-01-01 11:00:00'),
            Moment::fromString('2026-01-01 12:00:00'),
            Moment::fromString('2026-01-01 10:00:00'),
        ]);

        // -- Act & Assert
        self::assertEquals(Moment::fromString('2026-01-01 10:00:00'), $collection->min());
        self::assertEquals(Moment::fromString('2026-01-01 12:00:00'), $collection->max());
        self::assertNull(new Moments([])->min());
        self::assertNull(new Moments([])->max());
    }
}
