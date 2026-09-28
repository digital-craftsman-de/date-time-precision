<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Dates;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Dates;
use DigitalCraftsman\DateTimePrecision\Exception\CollectionContainsDuplicates;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Dates::class)]
#[CoversClass(CollectionContainsDuplicates::class)]
final class FromListRemovingDuplicatesTest extends TestCase
{
    #[Test]
    public function from_list_removing_duplicates_works(): void
    {
        // -- Act
        $collection = Dates::fromListRemovingDuplicates([
            Date::fromString('2026-01-01'),
            Date::fromString('2026-01-02'),
            Date::fromString('2026-01-01'),
            Date::fromString('2026-01-03'),
            Date::fromString('2026-01-02'),
        ]);

        // -- Assert
        self::assertEquals(new Dates([
            Date::fromString('2026-01-01'),
            Date::fromString('2026-01-02'),
            Date::fromString('2026-01-03'),
        ]), $collection);
    }

    #[Test]
    public function construction_fails_with_duplicates(): void
    {
        // -- Assert
        $this->expectException(CollectionContainsDuplicates::class);

        // -- Act
        new Dates([
            Date::fromString('2026-01-01'),
            Date::fromString('2026-01-02'),
            Date::fromString('2026-01-01'),
        ]);
    }
}
