<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\CalendarUnits;

use DigitalCraftsman\DateTimePrecision\CalendarUnit;
use DigitalCraftsman\DateTimePrecision\CalendarUnits;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(CalendarUnits::class)]
final class IsEqualToTest extends TestCase
{
    #[Test]
    public function is_equal_to_works(): void
    {
        // -- Arrange
        $collection = new CalendarUnits([
            CalendarUnit::DAY,
            CalendarUnit::WEEK,
        ]);

        // -- Act & Assert
        self::assertTrue($collection->isEqualTo(new CalendarUnits([
            CalendarUnit::DAY,
            CalendarUnit::WEEK,
        ])));
        self::assertTrue($collection->isEqualTo(new CalendarUnits([
            CalendarUnit::WEEK,
            CalendarUnit::DAY,
        ])));
        self::assertFalse($collection->isEqualTo(new CalendarUnits([
            CalendarUnit::DAY,
        ])));
        self::assertFalse(new CalendarUnits([
            CalendarUnit::DAY,
        ])->isEqualTo($collection));
        self::assertFalse($collection->isEqualTo(new CalendarUnits([
            CalendarUnit::DAY,
            CalendarUnit::MONTH,
        ])));
        self::assertTrue(new CalendarUnits([])->isEqualTo(new CalendarUnits([])));
    }

    #[Test]
    public function is_not_equal_to_works(): void
    {
        // -- Arrange
        $collection = new CalendarUnits([
            CalendarUnit::DAY,
            CalendarUnit::WEEK,
        ]);

        // -- Act & Assert
        self::assertFalse($collection->isNotEqualTo(new CalendarUnits([
            CalendarUnit::WEEK,
            CalendarUnit::DAY,
        ])));
        self::assertTrue($collection->isNotEqualTo(new CalendarUnits([
            CalendarUnit::DAY,
            CalendarUnit::MONTH,
        ])));
    }
}
