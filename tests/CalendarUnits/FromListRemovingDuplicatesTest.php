<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\CalendarUnits;

use DigitalCraftsman\DateTimePrecision\CalendarUnit;
use DigitalCraftsman\DateTimePrecision\CalendarUnits;
use DigitalCraftsman\DateTimePrecision\Exception\CollectionContainsDuplicates;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(CalendarUnits::class)]
#[CoversClass(CollectionContainsDuplicates::class)]
final class FromListRemovingDuplicatesTest extends TestCase
{
    #[Test]
    public function from_list_removing_duplicates_works(): void
    {
        // -- Act
        $collection = CalendarUnits::fromListRemovingDuplicates([
            CalendarUnit::DAY,
            CalendarUnit::WEEK,
            CalendarUnit::DAY,
            CalendarUnit::MONTH,
            CalendarUnit::WEEK,
        ]);

        // -- Assert
        self::assertEquals(new CalendarUnits([
            CalendarUnit::DAY,
            CalendarUnit::WEEK,
            CalendarUnit::MONTH,
        ]), $collection);
    }

    #[Test]
    public function construction_fails_with_duplicates(): void
    {
        // -- Assert
        $this->expectException(CollectionContainsDuplicates::class);

        // -- Act
        new CalendarUnits([
            CalendarUnit::DAY,
            CalendarUnit::WEEK,
            CalendarUnit::DAY,
        ]);
    }
}
