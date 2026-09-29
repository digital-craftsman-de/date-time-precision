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
final class SortTest extends TestCase
{
    #[Test]
    public function sort_works_with_comparator(): void
    {
        // -- Arrange
        $collection = new DateRanges([
            new DateRange(Date::fromString('2026-02-01'), Date::fromString('2026-02-10')),
            new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-10')),
            new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-11')),
        ]);

        // -- Act & Assert
        self::assertEquals(new DateRanges([
            new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-10')),
            new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-11')),
            new DateRange(Date::fromString('2026-02-01'), Date::fromString('2026-02-10')),
        ]), $collection->sort(static fn (DateRange $x, DateRange $y): int => $x->end->compareTo($y->end)));
    }
}
