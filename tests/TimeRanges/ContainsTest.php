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
final class ContainsTest extends TestCase
{
    #[Test]
    public function contains_works(): void
    {
        // -- Arrange
        $collection = new TimeRanges([
            new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
            new TimeRange(Time::fromString('21:00:00'), Time::fromString('03:00:00')),
        ]);

        // -- Act & Assert
        self::assertTrue($collection->contains(new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00'))));
        self::assertTrue($collection->contains(new TimeRange(Time::fromString('21:00:00'), Time::fromString('03:00:00'))));
        self::assertFalse($collection->contains(new TimeRange(Time::fromString('00:00:00'), Time::fromString('00:00:00'))));
        self::assertFalse(new TimeRanges([])->contains(new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00'))));
    }

    #[Test]
    public function not_contains_works(): void
    {
        // -- Arrange
        $collection = new TimeRanges([
            new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
            new TimeRange(Time::fromString('21:00:00'), Time::fromString('03:00:00')),
        ]);

        // -- Act & Assert
        self::assertFalse($collection->notContains(new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00'))));
        self::assertTrue($collection->notContains(new TimeRange(Time::fromString('00:00:00'), Time::fromString('00:00:00'))));
    }
}
