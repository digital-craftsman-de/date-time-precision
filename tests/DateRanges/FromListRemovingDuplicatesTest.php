<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\DateRanges;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\DateRange;
use DigitalCraftsman\DateTimePrecision\DateRanges;
use DigitalCraftsman\DateTimePrecision\Exception\CollectionContainsDuplicates;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(DateRanges::class)]
#[CoversClass(CollectionContainsDuplicates::class)]
final class FromListRemovingDuplicatesTest extends TestCase
{
    #[Test]
    public function from_list_removing_duplicates_works(): void
    {
        // -- Act
        $collection = DateRanges::fromListRemovingDuplicates([
            new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-10')),
            new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-11')),
            new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-10')),
            new DateRange(Date::fromString('2026-02-01'), Date::fromString('2026-02-10')),
            new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-11')),
        ]);

        // -- Assert
        self::assertEquals(new DateRanges([
            new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-10')),
            new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-11')),
            new DateRange(Date::fromString('2026-02-01'), Date::fromString('2026-02-10')),
        ]), $collection);
    }

    #[Test]
    public function construction_fails_with_duplicates(): void
    {
        // -- Assert
        $this->expectException(CollectionContainsDuplicates::class);

        // -- Act
        new DateRanges([
            new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-10')),
            new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-11')),
            new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-10')),
        ]);
    }
}
