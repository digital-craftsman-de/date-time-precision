<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Days;

use DigitalCraftsman\DateTimePrecision\Day;
use DigitalCraftsman\DateTimePrecision\Days;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Days::class)]
final class IsEqualToTest extends TestCase
{
    #[Test]
    public function is_equal_to_works(): void
    {
        // -- Arrange
        $collection = new Days([
            new Day(1),
            new Day(15),
        ]);

        // -- Act & Assert
        self::assertTrue($collection->isEqualTo(new Days([
            new Day(1),
            new Day(15),
        ])));
        self::assertTrue($collection->isEqualTo(new Days([
            new Day(15),
            new Day(1),
        ])));
        self::assertFalse($collection->isEqualTo(new Days([
            new Day(1),
        ])));
        self::assertFalse(new Days([
            new Day(1),
        ])->isEqualTo($collection));
        self::assertFalse($collection->isEqualTo(new Days([
            new Day(1),
            new Day(31),
        ])));
        self::assertTrue(new Days([])->isEqualTo(new Days([])));
    }

    #[Test]
    public function is_not_equal_to_works(): void
    {
        // -- Arrange
        $collection = new Days([
            new Day(1),
            new Day(15),
        ]);

        // -- Act & Assert
        self::assertFalse($collection->isNotEqualTo(new Days([
            new Day(15),
            new Day(1),
        ])));
        self::assertTrue($collection->isNotEqualTo(new Days([
            new Day(1),
            new Day(31),
        ])));
    }
}
