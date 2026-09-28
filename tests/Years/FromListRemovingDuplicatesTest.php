<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Years;

use DigitalCraftsman\DateTimePrecision\Exception\CollectionContainsDuplicates;
use DigitalCraftsman\DateTimePrecision\Year;
use DigitalCraftsman\DateTimePrecision\Years;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Years::class)]
#[CoversClass(CollectionContainsDuplicates::class)]
final class FromListRemovingDuplicatesTest extends TestCase
{
    #[Test]
    public function from_list_removing_duplicates_works(): void
    {
        // -- Act
        $collection = Years::fromListRemovingDuplicates([
            new Year(2024),
            new Year(2025),
            new Year(2024),
            new Year(2026),
            new Year(2025),
        ]);

        // -- Assert
        self::assertEquals(new Years([
            new Year(2024),
            new Year(2025),
            new Year(2026),
        ]), $collection);
    }

    #[Test]
    public function construction_fails_with_duplicates(): void
    {
        // -- Assert
        $this->expectException(CollectionContainsDuplicates::class);

        // -- Act
        new Years([
            new Year(2024),
            new Year(2025),
            new Year(2024),
        ]);
    }
}
