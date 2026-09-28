<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Times;

use DigitalCraftsman\DateTimePrecision\Time;
use DigitalCraftsman\DateTimePrecision\Times;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Times::class)]
final class IsEqualToTest extends TestCase
{
    #[Test]
    public function is_equal_to_works(): void
    {
        // -- Arrange
        $collection = new Times([
            new Time(10, 0, 0),
            new Time(11, 0, 0),
        ]);

        // -- Act & Assert
        self::assertTrue($collection->isEqualTo(new Times([
            new Time(10, 0, 0),
            new Time(11, 0, 0),
        ])));
        self::assertTrue($collection->isEqualTo(new Times([
            new Time(11, 0, 0),
            new Time(10, 0, 0),
        ])));
        self::assertFalse($collection->isEqualTo(new Times([
            new Time(10, 0, 0),
        ])));
        self::assertFalse(new Times([
            new Time(10, 0, 0),
        ])->isEqualTo($collection));
        self::assertFalse($collection->isEqualTo(new Times([
            new Time(10, 0, 0),
            new Time(12, 0, 0),
        ])));
        self::assertTrue(new Times([])->isEqualTo(new Times([])));
    }

    #[Test]
    public function is_not_equal_to_works(): void
    {
        // -- Arrange
        $collection = new Times([
            new Time(10, 0, 0),
            new Time(11, 0, 0),
        ]);

        // -- Act & Assert
        self::assertFalse($collection->isNotEqualTo(new Times([
            new Time(11, 0, 0),
            new Time(10, 0, 0),
        ])));
        self::assertTrue($collection->isNotEqualTo(new Times([
            new Time(10, 0, 0),
            new Time(12, 0, 0),
        ])));
    }
}
