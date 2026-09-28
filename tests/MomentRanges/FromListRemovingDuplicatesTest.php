<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\MomentRanges;

use DigitalCraftsman\DateTimePrecision\Exception\CollectionContainsDuplicates;
use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\MomentRange;
use DigitalCraftsman\DateTimePrecision\MomentRanges;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(MomentRanges::class)]
#[CoversClass(CollectionContainsDuplicates::class)]
final class FromListRemovingDuplicatesTest extends TestCase
{
    #[Test]
    public function from_list_removing_duplicates_works(): void
    {
        // -- Act
        $collection = MomentRanges::fromListRemovingDuplicates([
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00')),
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 13:00:00')),
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00')),
            new MomentRange(Moment::fromString('2026-01-01 14:00:00'), Moment::fromString('2026-01-01 16:00:00')),
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 13:00:00')),
        ]);

        // -- Assert
        self::assertEquals(new MomentRanges([
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00')),
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 13:00:00')),
            new MomentRange(Moment::fromString('2026-01-01 14:00:00'), Moment::fromString('2026-01-01 16:00:00')),
        ]), $collection);
    }

    #[Test]
    public function construction_fails_with_duplicates(): void
    {
        // -- Assert
        $this->expectException(CollectionContainsDuplicates::class);

        // -- Act
        new MomentRanges([
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00')),
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 13:00:00')),
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00')),
        ]);
    }
}
