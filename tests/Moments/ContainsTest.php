<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moments;

use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\Moments;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Moments::class)]
final class ContainsTest extends TestCase
{
    #[Test]
    public function contains_works(): void
    {
        // -- Arrange
        $collection = new Moments([
            Moment::fromString('2026-01-01 10:00:00'),
            Moment::fromString('2026-01-01 11:00:00'),
        ]);

        // -- Act & Assert
        self::assertTrue($collection->contains(Moment::fromString('2026-01-01 10:00:00')));
        self::assertTrue($collection->contains(Moment::fromString('2026-01-01 11:00:00')));
        self::assertFalse($collection->contains(Moment::fromString('2026-01-01 12:00:00')));
        self::assertFalse(new Moments([])->contains(Moment::fromString('2026-01-01 10:00:00')));
    }

    #[Test]
    public function not_contains_works(): void
    {
        // -- Arrange
        $collection = new Moments([
            Moment::fromString('2026-01-01 10:00:00'),
            Moment::fromString('2026-01-01 11:00:00'),
        ]);

        // -- Act & Assert
        self::assertFalse($collection->notContains(Moment::fromString('2026-01-01 10:00:00')));
        self::assertTrue($collection->notContains(Moment::fromString('2026-01-01 12:00:00')));
    }
}
