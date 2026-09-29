<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Times;

use DigitalCraftsman\DateTimePrecision\Exception\CollectionContainsDuplicates;
use DigitalCraftsman\DateTimePrecision\Time;
use DigitalCraftsman\DateTimePrecision\Times;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Times::class)]
#[CoversClass(CollectionContainsDuplicates::class)]
final class FromListRemovingDuplicatesTest extends TestCase
{
    #[Test]
    public function from_list_removing_duplicates_works(): void
    {
        // -- Act
        $collection = Times::fromListRemovingDuplicates([
            new Time(10, 0, 0),
            new Time(11, 0, 0),
            new Time(10, 0, 0),
            new Time(12, 0, 0),
            new Time(11, 0, 0),
        ]);

        // -- Assert
        self::assertEquals(new Times([
            new Time(10, 0, 0),
            new Time(11, 0, 0),
            new Time(12, 0, 0),
        ]), $collection);
    }

    #[Test]
    public function construction_fails_with_duplicates(): void
    {
        // -- Assert
        $this->expectException(CollectionContainsDuplicates::class);

        // -- Act
        new Times([
            new Time(10, 0, 0),
            new Time(11, 0, 0),
            new Time(10, 0, 0),
        ]);
    }
}
