<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\CalendarPeriod;

use DigitalCraftsman\DateTimePrecision\CalendarPeriod;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(CalendarPeriod::class)]
final class NormalizationTest extends TestCase
{
    #[Test]
    public function normalize_works(): void
    {
        // -- Arrange
        $calendarPeriod = CalendarPeriod::quarters(2);

        // -- Act
        $normalizedCalendarPeriod = $calendarPeriod->normalize();
        $denormalizedCalendarPeriod = CalendarPeriod::denormalize($normalizedCalendarPeriod);

        // -- Assert
        self::assertSame([
            'amount' => 2,
            'unit' => 'QUARTER',
        ], $normalizedCalendarPeriod);
        self::assertEquals($calendarPeriod, $denormalizedCalendarPeriod);
    }

    #[Test]
    public function denormalize_when_not_null_works(): void
    {
        // -- Act & Assert
        self::assertNull(CalendarPeriod::denormalizeWhenNotNull(null));
        self::assertEquals(CalendarPeriod::days(1), CalendarPeriod::denormalizeWhenNotNull([
            'amount' => 1,
            'unit' => 'DAY',
        ]));
    }
}
