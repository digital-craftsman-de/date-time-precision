<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moments;

use DigitalCraftsman\DateTimePrecision\Exception\CollectionContainsDuplicates;
use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\Moments;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Moments::class)]
#[CoversClass(CollectionContainsDuplicates::class)]
final class FromListRemovingDuplicatesTest extends TestCase
{
    #[Test]
    public function from_list_removing_duplicates_works(): void
    {
        // -- Act
        $collection = Moments::fromListRemovingDuplicates([
            Moment::fromString('2026-01-01 10:00:00'),
            Moment::fromString('2026-01-01 11:00:00'),
            Moment::fromString('2026-01-01 10:00:00'),
            Moment::fromString('2026-01-01 12:00:00'),
            Moment::fromString('2026-01-01 11:00:00'),
        ]);

        // -- Assert
        self::assertEquals(new Moments([
            Moment::fromString('2026-01-01 10:00:00'),
            Moment::fromString('2026-01-01 11:00:00'),
            Moment::fromString('2026-01-01 12:00:00'),
        ]), $collection);
    }

    #[Test]
    public function construction_fails_with_duplicates(): void
    {
        // -- Assert
        $this->expectException(CollectionContainsDuplicates::class);

        // -- Act
        new Moments([
            Moment::fromString('2026-01-01 10:00:00'),
            Moment::fromString('2026-01-01 11:00:00'),
            Moment::fromString('2026-01-01 10:00:00'),
        ]);
    }
}
