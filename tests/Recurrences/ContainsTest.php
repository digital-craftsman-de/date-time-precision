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
final class ContainsTest extends TestCase
{
    #[Test]
    public function contains_works(): void
    {
        // -- Arrange
        $collection = new Recurrences([
            Recurrence::daily(),
            Recurrence::weekly(new Weekdays([Weekday::MONDAY])),
        ]);

        // -- Act & Assert
        self::assertTrue($collection->contains(Recurrence::daily()));
        self::assertTrue($collection->contains(Recurrence::weekly(new Weekdays([Weekday::MONDAY]))));
        self::assertFalse($collection->contains(Recurrence::monthly(new Days([new Day(1)]))));
        self::assertFalse(new Recurrences([])->contains(Recurrence::daily()));
        self::assertFalse($collection->notContains(Recurrence::daily()));
        self::assertTrue($collection->notContains(Recurrence::monthly(new Days([new Day(1)]))));
    }
}
