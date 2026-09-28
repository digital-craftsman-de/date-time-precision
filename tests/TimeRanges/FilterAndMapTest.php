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
final class FilterAndMapTest extends TestCase
{
    #[Test]
    public function filter_works(): void
    {
        // -- Arrange
        $collection = new TimeRanges([
            new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
            new TimeRange(Time::fromString('21:00:00'), Time::fromString('03:00:00')),
            new TimeRange(Time::fromString('00:00:00'), Time::fromString('00:00:00')),
        ]);
        $excluded = new TimeRange(Time::fromString('21:00:00'), Time::fromString('03:00:00'));

        // -- Act
        $filteredCollection = $collection->filter(static fn (TimeRange $value): bool => $value->normalize() !== $excluded->normalize());

        // -- Assert
        self::assertEquals(new TimeRanges([
            new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
            new TimeRange(Time::fromString('00:00:00'), Time::fromString('00:00:00')),
        ]), $filteredCollection);
    }

    #[Test]
    public function map_works(): void
    {
        // -- Arrange
        $collection = new TimeRanges([
            new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
            new TimeRange(Time::fromString('21:00:00'), Time::fromString('03:00:00')),
        ]);

        // -- Act & Assert
        self::assertSame(
            $collection->normalize(),
            $collection->map(static fn (TimeRange $value): mixed => $value->normalize()),
        );
        self::assertSame([], new TimeRanges([])->map(static fn (TimeRange $value): mixed => $value->normalize()));
    }
}
