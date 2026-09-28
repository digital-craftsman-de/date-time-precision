<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\TimeRanges;

use DigitalCraftsman\DateTimePrecision\Time;
use DigitalCraftsman\DateTimePrecision\TimeRange;
use DigitalCraftsman\DateTimePrecision\TimeRanges;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(TimeRanges::class)]
final class CountTest extends TestCase
{
    #[Test]
    public function count_and_iteration_works(): void
    {
        // -- Arrange
        $collection = new TimeRanges([
            new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
            new TimeRange(Time::fromString('21:00:00'), Time::fromString('03:00:00')),
        ]);

        // -- Act & Assert
        self::assertCount(2, $collection);
        self::assertSame(2, $collection->count());
        self::assertEquals([
            new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
            new TimeRange(Time::fromString('21:00:00'), Time::fromString('03:00:00')),
        ], iterator_to_array($collection));
        self::assertFalse($collection->isEmpty());
        self::assertTrue($collection->isNotEmpty());
    }

    #[Test]
    public function count_and_iteration_works_without_elements(): void
    {
        // -- Arrange
        $collection = new TimeRanges([]);

        // -- Act & Assert
        self::assertCount(0, $collection);
        self::assertSame([], iterator_to_array($collection));
        self::assertTrue($collection->isEmpty());
        self::assertFalse($collection->isNotEmpty());
    }
}
