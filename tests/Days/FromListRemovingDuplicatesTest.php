<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Days;

use DigitalCraftsman\DateTimePrecision\Day;
use DigitalCraftsman\DateTimePrecision\Days;
use DigitalCraftsman\DateTimePrecision\Exception\CollectionContainsDuplicates;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Days::class)]
#[CoversClass(CollectionContainsDuplicates::class)]
final class FromListRemovingDuplicatesTest extends TestCase
{
    #[Test]
    public function from_list_removing_duplicates_works(): void
    {
        // -- Act
        $collection = Days::fromListRemovingDuplicates([
            new Day(1),
            new Day(15),
            new Day(1),
            new Day(31),
            new Day(15),
        ]);

        // -- Assert
        self::assertEquals(new Days([
            new Day(1),
            new Day(15),
            new Day(31),
        ]), $collection);
    }

    #[Test]
    public function construction_fails_with_duplicates(): void
    {
        // -- Assert
        $this->expectException(CollectionContainsDuplicates::class);

        // -- Act
        new Days([
            new Day(1),
            new Day(15),
            new Day(1),
        ]);
    }
}
