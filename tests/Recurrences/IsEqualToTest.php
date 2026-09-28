<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Recurrences;

use DigitalCraftsman\DateTimePrecision\Day;
use DigitalCraftsman\DateTimePrecision\Days;
use DigitalCraftsman\DateTimePrecision\Recurrence;
use DigitalCraftsman\DateTimePrecision\Recurrences;
use DigitalCraftsman\DateTimePrecision\Weekday;
use DigitalCraftsman\DateTimePrecision\Weekdays;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Recurrences::class)]
final class IsEqualToTest extends TestCase
{
    #[Test]
    public function is_equal_to_works(): void
    {
        // -- Arrange
        $collection = new Recurrences([
            Recurrence::daily(),
            Recurrence::weekly(new Weekdays([Weekday::MONDAY])),
        ]);

        // -- Act & Assert
        self::assertTrue($collection->isEqualTo(new Recurrences([
            Recurrence::daily(),
            Recurrence::weekly(new Weekdays([Weekday::MONDAY])),
        ])));
        self::assertTrue($collection->isEqualTo(new Recurrences([
            Recurrence::weekly(new Weekdays([Weekday::MONDAY])),
            Recurrence::daily(),
        ])));
        self::assertFalse($collection->isEqualTo(new Recurrences([
            Recurrence::daily(),
        ])));
        self::assertFalse(new Recurrences([
            Recurrence::daily(),
        ])->isEqualTo($collection));
        self::assertFalse($collection->isEqualTo(new Recurrences([
            Recurrence::daily(),
            Recurrence::monthly(new Days([new Day(1)])),
        ])));
        self::assertTrue(new Recurrences([])->isEqualTo(new Recurrences([])));
    }

    #[Test]
    public function is_not_equal_to_works(): void
    {
        // -- Arrange
        $collection = new Recurrences([
            Recurrence::daily(),
            Recurrence::weekly(new Weekdays([Weekday::MONDAY])),
        ]);

        // -- Act & Assert
        self::assertFalse($collection->isNotEqualTo(new Recurrences([
            Recurrence::weekly(new Weekdays([Weekday::MONDAY])),
            Recurrence::daily(),
        ])));
        self::assertTrue($collection->isNotEqualTo(new Recurrences([
            Recurrence::daily(),
            Recurrence::monthly(new Days([new Day(1)])),
        ])));
    }
}
