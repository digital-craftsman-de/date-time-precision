<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\CalendarPeriods;

use DigitalCraftsman\DateTimePrecision\CalendarPeriod;
use DigitalCraftsman\DateTimePrecision\CalendarPeriods;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(CalendarPeriods::class)]
final class NormalizationTest extends TestCase
{
    #[Test]
    public function normalize_works(): void
    {
        // -- Arrange
        $collection = new CalendarPeriods([
            CalendarPeriod::weeks(1),
            CalendarPeriod::days(7),
        ]);

        // -- Act
        $normalizedCollection = $collection->normalize();
        $denormalizedCollection = CalendarPeriods::denormalize($normalizedCollection);

        // -- Assert
        self::assertSame([
            ['amount' => 1, 'unit' => 'WEEK'],
            ['amount' => 7, 'unit' => 'DAY'],
        ], $normalizedCollection);
        self::assertEquals($collection, $denormalizedCollection);
    }

    #[Test]
    public function denormalize_when_not_null_works(): void
    {
        // -- Act & Assert
        self::assertNull(CalendarPeriods::denormalizeWhenNotNull(null));
        self::assertEquals(new CalendarPeriods([]), CalendarPeriods::denormalizeWhenNotNull([]));
    }
}
