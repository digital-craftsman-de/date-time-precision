<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\CalendarUnits;

use DigitalCraftsman\DateTimePrecision\CalendarUnit;
use DigitalCraftsman\DateTimePrecision\CalendarUnits;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(CalendarUnits::class)]
final class ContainsTest extends TestCase
{
    #[Test]
    public function contains_works(): void
    {
        // -- Arrange
        $collection = new CalendarUnits([
            CalendarUnit::DAY,
            CalendarUnit::WEEK,
        ]);

        // -- Act & Assert
        self::assertTrue($collection->contains(CalendarUnit::DAY));
        self::assertTrue($collection->contains(CalendarUnit::WEEK));
        self::assertFalse($collection->contains(CalendarUnit::MONTH));
        self::assertFalse(new CalendarUnits([])->contains(CalendarUnit::DAY));
    }

    #[Test]
    public function not_contains_works(): void
    {
        // -- Arrange
        $collection = new CalendarUnits([
            CalendarUnit::DAY,
            CalendarUnit::WEEK,
        ]);

        // -- Act & Assert
        self::assertFalse($collection->notContains(CalendarUnit::DAY));
        self::assertTrue($collection->notContains(CalendarUnit::MONTH));
    }
}
