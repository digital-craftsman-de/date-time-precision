<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\TimeRange;

use DigitalCraftsman\DateTimePrecision\Time;
use DigitalCraftsman\DateTimePrecision\TimeRange;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(TimeRange::class)]
final class NormalizationTest extends TestCase
{
    #[Test]
    public function normalize_works(): void
    {
        // -- Arrange
        $timeRange = new TimeRange(Time::fromString('21:00:00'), Time::fromString('03:00:00'));

        // -- Act
        $normalizedTimeRange = $timeRange->normalize();
        $denormalizedTimeRange = TimeRange::denormalize($normalizedTimeRange);

        // -- Assert
        self::assertSame([
            'start' => '21:00:00',
            'end' => '03:00:00',
        ], $normalizedTimeRange);
        self::assertEquals($timeRange, $denormalizedTimeRange);
    }

    #[Test]
    public function denormalize_when_not_null_works(): void
    {
        // -- Act & Assert
        self::assertNull(TimeRange::denormalizeWhenNotNull(null));
        self::assertEquals(
            new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
            TimeRange::denormalizeWhenNotNull([
                'start' => '10:00:00',
                'end' => '12:00:00',
            ]),
        );
    }
}
