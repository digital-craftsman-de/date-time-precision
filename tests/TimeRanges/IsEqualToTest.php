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
final class IsEqualToTest extends TestCase
{
    #[Test]
    public function is_equal_to_works(): void
    {
        // -- Arrange
        $collection = new TimeRanges([
            new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
            new TimeRange(Time::fromString('21:00:00'), Time::fromString('03:00:00')),
        ]);

        // -- Act & Assert
        self::assertTrue($collection->isEqualTo(new TimeRanges([
            new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
            new TimeRange(Time::fromString('21:00:00'), Time::fromString('03:00:00')),
        ])));
        self::assertTrue($collection->isEqualTo(new TimeRanges([
            new TimeRange(Time::fromString('21:00:00'), Time::fromString('03:00:00')),
            new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
        ])));
        self::assertFalse($collection->isEqualTo(new TimeRanges([
            new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
        ])));
        self::assertFalse(new TimeRanges([
            new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
        ])->isEqualTo($collection));
        self::assertFalse($collection->isEqualTo(new TimeRanges([
            new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
            new TimeRange(Time::fromString('00:00:00'), Time::fromString('00:00:00')),
        ])));
        self::assertTrue(new TimeRanges([])->isEqualTo(new TimeRanges([])));
    }

    #[Test]
    public function is_not_equal_to_works(): void
    {
        // -- Arrange
        $collection = new TimeRanges([
            new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
            new TimeRange(Time::fromString('21:00:00'), Time::fromString('03:00:00')),
        ]);

        // -- Act & Assert
        self::assertFalse($collection->isNotEqualTo(new TimeRanges([
            new TimeRange(Time::fromString('21:00:00'), Time::fromString('03:00:00')),
            new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
        ])));
        self::assertTrue($collection->isNotEqualTo(new TimeRanges([
            new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
            new TimeRange(Time::fromString('00:00:00'), Time::fromString('00:00:00')),
        ])));
    }
}
