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
final class NormalizationTest extends TestCase
{
    #[Test]
    public function normalize_works(): void
    {
        // -- Arrange
        $collection = new TimeRanges([
            new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
            new TimeRange(Time::fromString('21:00:00'), Time::fromString('03:00:00')),
        ]);

        // -- Act
        $normalizedCollection = $collection->normalize();
        $denormalizedCollection = TimeRanges::denormalize($normalizedCollection);

        // -- Assert
        self::assertSame([
            ['start' => '10:00:00', 'end' => '12:00:00'],
            ['start' => '21:00:00', 'end' => '03:00:00'],
        ], $normalizedCollection);
        self::assertEquals($collection, $denormalizedCollection);
    }

    #[Test]
    public function denormalize_when_not_null_works(): void
    {
        // -- Act & Assert
        self::assertNull(TimeRanges::denormalizeWhenNotNull(null));
        self::assertEquals(new TimeRanges([]), TimeRanges::denormalizeWhenNotNull([]));
    }
}
