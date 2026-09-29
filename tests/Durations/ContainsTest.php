<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Durations;

use DigitalCraftsman\DateTimePrecision\Duration;
use DigitalCraftsman\DateTimePrecision\Durations;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Durations::class)]
final class ContainsTest extends TestCase
{
    #[Test]
    public function contains_works(): void
    {
        // -- Arrange
        $collection = new Durations([
            Duration::fromMinutes(15),
            Duration::fromMinutes(30),
        ]);

        // -- Act & Assert
        self::assertTrue($collection->contains(Duration::fromMinutes(15)));
        self::assertTrue($collection->contains(Duration::fromMinutes(30)));
        self::assertFalse($collection->contains(Duration::fromMinutes(45)));
        self::assertFalse(new Durations([])->contains(Duration::fromMinutes(15)));
    }

    #[Test]
    public function not_contains_works(): void
    {
        // -- Arrange
        $collection = new Durations([
            Duration::fromMinutes(15),
            Duration::fromMinutes(30),
        ]);

        // -- Act & Assert
        self::assertFalse($collection->notContains(Duration::fromMinutes(15)));
        self::assertTrue($collection->notContains(Duration::fromMinutes(45)));
    }
}
