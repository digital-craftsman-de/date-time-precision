<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Dates;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Dates;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Dates::class)]
final class ContainsTest extends TestCase
{
    #[Test]
    public function contains_works(): void
    {
        // -- Arrange
        $collection = new Dates([
            Date::fromString('2026-01-01'),
            Date::fromString('2026-01-02'),
        ]);

        // -- Act & Assert
        self::assertTrue($collection->contains(Date::fromString('2026-01-01')));
        self::assertTrue($collection->contains(Date::fromString('2026-01-02')));
        self::assertFalse($collection->contains(Date::fromString('2026-01-03')));
        self::assertFalse(new Dates([])->contains(Date::fromString('2026-01-01')));
    }

    #[Test]
    public function not_contains_works(): void
    {
        // -- Arrange
        $collection = new Dates([
            Date::fromString('2026-01-01'),
            Date::fromString('2026-01-02'),
        ]);

        // -- Act & Assert
        self::assertFalse($collection->notContains(Date::fromString('2026-01-01')));
        self::assertTrue($collection->notContains(Date::fromString('2026-01-03')));
    }
}
