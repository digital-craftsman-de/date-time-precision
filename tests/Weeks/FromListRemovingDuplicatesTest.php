<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Weeks;

use DigitalCraftsman\DateTimePrecision\Exception\CollectionContainsDuplicates;
use DigitalCraftsman\DateTimePrecision\Week;
use DigitalCraftsman\DateTimePrecision\Weeks;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Weeks::class)]
#[CoversClass(CollectionContainsDuplicates::class)]
final class FromListRemovingDuplicatesTest extends TestCase
{
    #[Test]
    public function from_list_removing_duplicates_works(): void
    {
        // -- Act
        $collection = Weeks::fromListRemovingDuplicates([
            Week::fromString('2026-W01'),
            Week::fromString('2026-W02'),
            Week::fromString('2026-W01'),
            Week::fromString('2026-W03'),
            Week::fromString('2026-W02'),
        ]);

        // -- Assert
        self::assertEquals(new Weeks([
            Week::fromString('2026-W01'),
            Week::fromString('2026-W02'),
            Week::fromString('2026-W03'),
        ]), $collection);
    }

    #[Test]
    public function construction_fails_with_duplicates(): void
    {
        // -- Assert
        $this->expectException(CollectionContainsDuplicates::class);

        // -- Act
        new Weeks([
            Week::fromString('2026-W01'),
            Week::fromString('2026-W02'),
            Week::fromString('2026-W01'),
        ]);
    }
}
