<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moments;

use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\Moments;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Moments::class)]
final class IsEqualToTest extends TestCase
{
    #[Test]
    public function is_equal_to_works(): void
    {
        // -- Arrange
        $collection = new Moments([
            Moment::fromString('2026-01-01 10:00:00'),
            Moment::fromString('2026-01-01 11:00:00'),
        ]);

        // -- Act & Assert
        self::assertTrue($collection->isEqualTo(new Moments([
            Moment::fromString('2026-01-01 10:00:00'),
            Moment::fromString('2026-01-01 11:00:00'),
        ])));
        self::assertTrue($collection->isEqualTo(new Moments([
            Moment::fromString('2026-01-01 11:00:00'),
            Moment::fromString('2026-01-01 10:00:00'),
        ])));
        self::assertFalse($collection->isEqualTo(new Moments([
            Moment::fromString('2026-01-01 10:00:00'),
        ])));
        self::assertFalse(new Moments([
            Moment::fromString('2026-01-01 10:00:00'),
        ])->isEqualTo($collection));
        self::assertFalse($collection->isEqualTo(new Moments([
            Moment::fromString('2026-01-01 10:00:00'),
            Moment::fromString('2026-01-01 12:00:00'),
        ])));
        self::assertTrue(new Moments([])->isEqualTo(new Moments([])));
    }

    #[Test]
    public function is_not_equal_to_works(): void
    {
        // -- Arrange
        $collection = new Moments([
            Moment::fromString('2026-01-01 10:00:00'),
            Moment::fromString('2026-01-01 11:00:00'),
        ]);

        // -- Act & Assert
        self::assertFalse($collection->isNotEqualTo(new Moments([
            Moment::fromString('2026-01-01 11:00:00'),
            Moment::fromString('2026-01-01 10:00:00'),
        ])));
        self::assertTrue($collection->isNotEqualTo(new Moments([
            Moment::fromString('2026-01-01 10:00:00'),
            Moment::fromString('2026-01-01 12:00:00'),
        ])));
    }
}
