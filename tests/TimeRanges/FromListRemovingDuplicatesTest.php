<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\TimeRanges;

use DigitalCraftsman\DateTimePrecision\Exception\CollectionContainsDuplicates;
use DigitalCraftsman\DateTimePrecision\Time;
use DigitalCraftsman\DateTimePrecision\TimeRange;
use DigitalCraftsman\DateTimePrecision\TimeRanges;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(TimeRanges::class)]
#[CoversClass(CollectionContainsDuplicates::class)]
final class FromListRemovingDuplicatesTest extends TestCase
{
    #[Test]
    public function from_list_removing_duplicates_works(): void
    {
        // -- Act
        $collection = TimeRanges::fromListRemovingDuplicates([
            new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
            new TimeRange(Time::fromString('21:00:00'), Time::fromString('03:00:00')),
            new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
            new TimeRange(Time::fromString('00:00:00'), Time::fromString('00:00:00')),
            new TimeRange(Time::fromString('21:00:00'), Time::fromString('03:00:00')),
        ]);

        // -- Assert
        self::assertEquals(new TimeRanges([
            new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
            new TimeRange(Time::fromString('21:00:00'), Time::fromString('03:00:00')),
            new TimeRange(Time::fromString('00:00:00'), Time::fromString('00:00:00')),
        ]), $collection);
    }

    #[Test]
    public function construction_fails_with_duplicates(): void
    {
        // -- Assert
        $this->expectException(CollectionContainsDuplicates::class);

        // -- Act
        new TimeRanges([
            new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
            new TimeRange(Time::fromString('21:00:00'), Time::fromString('03:00:00')),
            new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
        ]);
    }
}
