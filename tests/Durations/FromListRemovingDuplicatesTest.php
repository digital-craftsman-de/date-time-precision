<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Durations;

use DigitalCraftsman\DateTimePrecision\Duration;
use DigitalCraftsman\DateTimePrecision\Durations;
use DigitalCraftsman\DateTimePrecision\Exception\CollectionContainsDuplicates;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Durations::class)]
#[CoversClass(CollectionContainsDuplicates::class)]
final class FromListRemovingDuplicatesTest extends TestCase
{
    #[Test]
    public function from_list_removing_duplicates_works(): void
    {
        // -- Act
        $collection = Durations::fromListRemovingDuplicates([
            Duration::fromMinutes(15),
            Duration::fromMinutes(30),
            Duration::fromMinutes(15),
            Duration::fromMinutes(45),
            Duration::fromMinutes(30),
        ]);

        // -- Assert
        self::assertEquals(new Durations([
            Duration::fromMinutes(15),
            Duration::fromMinutes(30),
            Duration::fromMinutes(45),
        ]), $collection);
    }

    #[Test]
    public function construction_fails_with_duplicates(): void
    {
        // -- Assert
        $this->expectException(CollectionContainsDuplicates::class);

        // -- Act
        new Durations([
            Duration::fromMinutes(15),
            Duration::fromMinutes(30),
            Duration::fromMinutes(15),
        ]);
    }
}
