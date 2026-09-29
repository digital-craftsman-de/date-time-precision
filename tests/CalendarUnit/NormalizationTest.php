<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\CalendarUnit;

use DigitalCraftsman\DateTimePrecision\CalendarUnit;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(CalendarUnit::class)]
final class NormalizationTest extends TestCase
{
    #[Test]
    public function normalize_works(): void
    {
        foreach (CalendarUnit::cases() as $calendarUnit) {
            // -- Act
            $normalizedCalendarUnit = $calendarUnit->normalize();
            $denormalizedCalendarUnit = CalendarUnit::denormalize($normalizedCalendarUnit);

            // -- Assert
            self::assertSame($calendarUnit->value, $normalizedCalendarUnit);
            self::assertSame($calendarUnit, $denormalizedCalendarUnit);
        }
    }
}
