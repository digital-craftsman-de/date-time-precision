<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Weekdays;

use DigitalCraftsman\DateTimePrecision\Exception\CollectionContainsDuplicates;
use DigitalCraftsman\DateTimePrecision\Weekday;
use DigitalCraftsman\DateTimePrecision\Weekdays;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Weekdays::class)]
#[CoversClass(CollectionContainsDuplicates::class)]
final class FromListRemovingDuplicatesTest extends TestCase
{
    #[Test]
    public function from_list_removing_duplicates_works(): void
    {
        // -- Act
        $collection = Weekdays::fromListRemovingDuplicates([
            Weekday::MONDAY,
            Weekday::TUESDAY,
            Weekday::MONDAY,
            Weekday::WEDNESDAY,
            Weekday::TUESDAY,
        ]);

        // -- Assert
        self::assertEquals(new Weekdays([
            Weekday::MONDAY,
            Weekday::TUESDAY,
            Weekday::WEDNESDAY,
        ]), $collection);
    }

    #[Test]
    public function construction_fails_with_duplicates(): void
    {
        // -- Assert
        $this->expectException(CollectionContainsDuplicates::class);

        // -- Act
        new Weekdays([
            Weekday::MONDAY,
            Weekday::TUESDAY,
            Weekday::MONDAY,
        ]);
    }
}
