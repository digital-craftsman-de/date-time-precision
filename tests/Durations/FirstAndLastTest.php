<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Durations;

use DigitalCraftsman\DateTimePrecision\Duration;
use DigitalCraftsman\DateTimePrecision\Durations;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Durations::class)]
final class FirstAndLastTest extends TestCase
{
    #[Test]
    public function first_and_last_works(): void
    {
        // -- Arrange
        $collection = new Durations([
            Duration::fromMinutes(15),
            Duration::fromMinutes(30),
            Duration::fromMinutes(45),
        ]);

        // -- Act & Assert
        self::assertEquals(Duration::fromMinutes(15), $collection->first());
        self::assertEquals(Duration::fromMinutes(45), $collection->last());
    }

    #[Test]
    public function first_and_last_works_without_elements(): void
    {
        // -- Arrange
        $collection = new Durations([]);

        // -- Act & Assert
        self::assertNull($collection->first());
        self::assertNull($collection->last());
    }
}
