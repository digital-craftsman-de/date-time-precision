<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Weekdays;

use DigitalCraftsman\DateTimePrecision\Weekday;
use DigitalCraftsman\DateTimePrecision\Weekdays;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Weekdays::class)]
final class IsEqualToTest extends TestCase
{
    #[Test]
    public function is_equal_to_works(): void
    {
        // -- Arrange
        $collection = new Weekdays([
            Weekday::MONDAY,
            Weekday::TUESDAY,
        ]);

        // -- Act & Assert
        self::assertTrue($collection->isEqualTo(new Weekdays([
            Weekday::MONDAY,
            Weekday::TUESDAY,
        ])));
        self::assertTrue($collection->isEqualTo(new Weekdays([
            Weekday::TUESDAY,
            Weekday::MONDAY,
        ])));
        self::assertFalse($collection->isEqualTo(new Weekdays([
            Weekday::MONDAY,
        ])));
        self::assertFalse(new Weekdays([
            Weekday::MONDAY,
        ])->isEqualTo($collection));
        self::assertFalse($collection->isEqualTo(new Weekdays([
            Weekday::MONDAY,
            Weekday::WEDNESDAY,
        ])));
        self::assertTrue(new Weekdays([])->isEqualTo(new Weekdays([])));
    }

    #[Test]
    public function is_not_equal_to_works(): void
    {
        // -- Arrange
        $collection = new Weekdays([
            Weekday::MONDAY,
            Weekday::TUESDAY,
        ]);

        // -- Act & Assert
        self::assertFalse($collection->isNotEqualTo(new Weekdays([
            Weekday::TUESDAY,
            Weekday::MONDAY,
        ])));
        self::assertTrue($collection->isNotEqualTo(new Weekdays([
            Weekday::MONDAY,
            Weekday::WEDNESDAY,
        ])));
    }
}
