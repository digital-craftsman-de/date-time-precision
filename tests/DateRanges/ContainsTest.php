<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\DateRanges;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\DateRange;
use DigitalCraftsman\DateTimePrecision\DateRanges;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(DateRanges::class)]
final class ContainsTest extends TestCase
{
    #[Test]
    public function contains_works(): void
    {
        // -- Arrange
        $collection = new DateRanges([
            new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-10')),
            new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-11')),
        ]);

        // -- Act & Assert
        self::assertTrue($collection->contains(new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-10'))));
        self::assertTrue($collection->contains(new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-11'))));
        self::assertFalse($collection->contains(new DateRange(Date::fromString('2026-02-01'), Date::fromString('2026-02-10'))));
        self::assertFalse(new DateRanges([])->contains(new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-10'))));
    }

    #[Test]
    public function not_contains_works(): void
    {
        // -- Arrange
        $collection = new DateRanges([
            new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-10')),
            new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-11')),
        ]);

        // -- Act & Assert
        self::assertFalse($collection->notContains(new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-10'))));
        self::assertTrue($collection->notContains(new DateRange(Date::fromString('2026-02-01'), Date::fromString('2026-02-10'))));
    }
}
