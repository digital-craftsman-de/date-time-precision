<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Dates;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Dates;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Dates::class)]
final class IsEqualToTest extends TestCase
{
    #[Test]
    public function is_equal_to_works(): void
    {
        // -- Arrange
        $collection = new Dates([
            Date::fromString('2026-01-01'),
            Date::fromString('2026-01-02'),
        ]);

        // -- Act & Assert
        self::assertTrue($collection->isEqualTo(new Dates([
            Date::fromString('2026-01-01'),
            Date::fromString('2026-01-02'),
        ])));
        self::assertTrue($collection->isEqualTo(new Dates([
            Date::fromString('2026-01-02'),
            Date::fromString('2026-01-01'),
        ])));
        self::assertFalse($collection->isEqualTo(new Dates([
            Date::fromString('2026-01-01'),
        ])));
        self::assertFalse(new Dates([
            Date::fromString('2026-01-01'),
        ])->isEqualTo($collection));
        self::assertFalse($collection->isEqualTo(new Dates([
            Date::fromString('2026-01-01'),
            Date::fromString('2026-01-03'),
        ])));
        self::assertTrue(new Dates([])->isEqualTo(new Dates([])));
    }

    #[Test]
    public function is_not_equal_to_works(): void
    {
        // -- Arrange
        $collection = new Dates([
            Date::fromString('2026-01-01'),
            Date::fromString('2026-01-02'),
        ]);

        // -- Act & Assert
        self::assertFalse($collection->isNotEqualTo(new Dates([
            Date::fromString('2026-01-02'),
            Date::fromString('2026-01-01'),
        ])));
        self::assertTrue($collection->isNotEqualTo(new Dates([
            Date::fromString('2026-01-01'),
            Date::fromString('2026-01-03'),
        ])));
    }
}
