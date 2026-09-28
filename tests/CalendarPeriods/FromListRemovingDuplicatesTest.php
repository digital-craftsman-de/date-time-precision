<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\CalendarPeriods;

use DigitalCraftsman\DateTimePrecision\CalendarPeriod;
use DigitalCraftsman\DateTimePrecision\CalendarPeriods;
use DigitalCraftsman\DateTimePrecision\Exception\CollectionContainsDuplicates;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(CalendarPeriods::class)]
#[CoversClass(CollectionContainsDuplicates::class)]
final class FromListRemovingDuplicatesTest extends TestCase
{
    #[Test]
    public function from_list_removing_duplicates_works(): void
    {
        // -- Act
        $collection = CalendarPeriods::fromListRemovingDuplicates([
            CalendarPeriod::weeks(1),
            CalendarPeriod::days(7),
            CalendarPeriod::weeks(1),
            CalendarPeriod::days(1),
            CalendarPeriod::days(7),
        ]);

        // -- Assert
        self::assertEquals(new CalendarPeriods([
            CalendarPeriod::weeks(1),
            CalendarPeriod::days(7),
            CalendarPeriod::days(1),
        ]), $collection);
    }

    #[Test]
    public function construction_fails_with_duplicates(): void
    {
        // -- Assert
        $this->expectException(CollectionContainsDuplicates::class);

        // -- Act
        new CalendarPeriods([
            CalendarPeriod::weeks(1),
            CalendarPeriod::days(7),
            CalendarPeriod::weeks(1),
        ]);
    }
}
