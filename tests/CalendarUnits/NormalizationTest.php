<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\CalendarUnits;

use DigitalCraftsman\DateTimePrecision\CalendarUnit;
use DigitalCraftsman\DateTimePrecision\CalendarUnits;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(CalendarUnits::class)]
final class NormalizationTest extends TestCase
{
    #[Test]
    public function normalize_works(): void
    {
        // -- Arrange
        $collection = new CalendarUnits([
            CalendarUnit::DAY,
            CalendarUnit::WEEK,
        ]);

        // -- Act
        $normalizedCollection = $collection->normalize();
        $denormalizedCollection = CalendarUnits::denormalize($normalizedCollection);

        // -- Assert
        self::assertSame([
            'DAY',
            'WEEK',
        ], $normalizedCollection);
        self::assertEquals($collection, $denormalizedCollection);
    }

    #[Test]
    public function denormalize_when_not_null_works(): void
    {
        // -- Act & Assert
        self::assertNull(CalendarUnits::denormalizeWhenNotNull(null));
        self::assertEquals(new CalendarUnits([]), CalendarUnits::denormalizeWhenNotNull([]));
    }
}
