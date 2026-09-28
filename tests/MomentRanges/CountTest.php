<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\MomentRanges;

use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\MomentRange;
use DigitalCraftsman\DateTimePrecision\MomentRanges;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(MomentRanges::class)]
final class CountTest extends TestCase
{
    #[Test]
    public function count_and_iteration_works(): void
    {
        // -- Arrange
        $collection = new MomentRanges([
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00')),
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 13:00:00')),
        ]);

        // -- Act & Assert
        self::assertCount(2, $collection);
        self::assertSame(2, $collection->count());
        self::assertEquals([
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00')),
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 13:00:00')),
        ], iterator_to_array($collection));
        self::assertFalse($collection->isEmpty());
        self::assertTrue($collection->isNotEmpty());
    }

    #[Test]
    public function count_and_iteration_works_without_elements(): void
    {
        // -- Arrange
        $collection = new MomentRanges([]);

        // -- Act & Assert
        self::assertCount(0, $collection);
        self::assertSame([], iterator_to_array($collection));
        self::assertTrue($collection->isEmpty());
        self::assertFalse($collection->isNotEmpty());
    }
}
