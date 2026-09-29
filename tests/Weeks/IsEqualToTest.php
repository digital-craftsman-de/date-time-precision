<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Weeks;

use DigitalCraftsman\DateTimePrecision\Week;
use DigitalCraftsman\DateTimePrecision\Weeks;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Weeks::class)]
final class IsEqualToTest extends TestCase
{
    #[Test]
    public function is_equal_to_works(): void
    {
        // -- Arrange
        $collection = new Weeks([
            Week::fromString('2026-W01'),
            Week::fromString('2026-W02'),
        ]);

        // -- Act & Assert
        self::assertTrue($collection->isEqualTo(new Weeks([
            Week::fromString('2026-W01'),
            Week::fromString('2026-W02'),
        ])));
        self::assertTrue($collection->isEqualTo(new Weeks([
            Week::fromString('2026-W02'),
            Week::fromString('2026-W01'),
        ])));
        self::assertFalse($collection->isEqualTo(new Weeks([
            Week::fromString('2026-W01'),
        ])));
        self::assertFalse(new Weeks([
            Week::fromString('2026-W01'),
        ])->isEqualTo($collection));
        self::assertFalse($collection->isEqualTo(new Weeks([
            Week::fromString('2026-W01'),
            Week::fromString('2026-W03'),
        ])));
        self::assertTrue(new Weeks([])->isEqualTo(new Weeks([])));
    }

    #[Test]
    public function is_not_equal_to_works(): void
    {
        // -- Arrange
        $collection = new Weeks([
            Week::fromString('2026-W01'),
            Week::fromString('2026-W02'),
        ]);

        // -- Act & Assert
        self::assertFalse($collection->isNotEqualTo(new Weeks([
            Week::fromString('2026-W02'),
            Week::fromString('2026-W01'),
        ])));
        self::assertTrue($collection->isNotEqualTo(new Weeks([
            Week::fromString('2026-W01'),
            Week::fromString('2026-W03'),
        ])));
    }
}
