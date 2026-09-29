<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Durations;

use DigitalCraftsman\DateTimePrecision\Duration;
use DigitalCraftsman\DateTimePrecision\Durations;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Durations::class)]
final class IsEqualToTest extends TestCase
{
    #[Test]
    public function is_equal_to_works(): void
    {
        // -- Arrange
        $collection = new Durations([
            Duration::fromMinutes(15),
            Duration::fromMinutes(30),
        ]);

        // -- Act & Assert
        self::assertTrue($collection->isEqualTo(new Durations([
            Duration::fromMinutes(15),
            Duration::fromMinutes(30),
        ])));
        self::assertTrue($collection->isEqualTo(new Durations([
            Duration::fromMinutes(30),
            Duration::fromMinutes(15),
        ])));
        self::assertFalse($collection->isEqualTo(new Durations([
            Duration::fromMinutes(15),
        ])));
        self::assertFalse(new Durations([
            Duration::fromMinutes(15),
        ])->isEqualTo($collection));
        self::assertFalse($collection->isEqualTo(new Durations([
            Duration::fromMinutes(15),
            Duration::fromMinutes(45),
        ])));
        self::assertTrue(new Durations([])->isEqualTo(new Durations([])));
    }

    #[Test]
    public function is_not_equal_to_works(): void
    {
        // -- Arrange
        $collection = new Durations([
            Duration::fromMinutes(15),
            Duration::fromMinutes(30),
        ]);

        // -- Act & Assert
        self::assertFalse($collection->isNotEqualTo(new Durations([
            Duration::fromMinutes(30),
            Duration::fromMinutes(15),
        ])));
        self::assertTrue($collection->isNotEqualTo(new Durations([
            Duration::fromMinutes(15),
            Duration::fromMinutes(45),
        ])));
    }
}
