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
final class FirstAndLastTest extends TestCase
{
    #[Test]
    public function first_and_last_works(): void
    {
        // -- Arrange
        $collection = new DateRanges([
            new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-10')),
            new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-11')),
            new DateRange(Date::fromString('2026-02-01'), Date::fromString('2026-02-10')),
        ]);

        // -- Act & Assert
        self::assertEquals(new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-10')), $collection->first());
        self::assertEquals(new DateRange(Date::fromString('2026-02-01'), Date::fromString('2026-02-10')), $collection->last());
    }

    #[Test]
    public function first_and_last_works_without_elements(): void
    {
        // -- Arrange
        $collection = new DateRanges([]);

        // -- Act & Assert
        self::assertNull($collection->first());
        self::assertNull($collection->last());
    }
}
