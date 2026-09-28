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
final class FirstAndLastTest extends TestCase
{
    #[Test]
    public function first_and_last_works(): void
    {
        // -- Arrange
        $collection = new MomentRanges([
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00')),
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 13:00:00')),
            new MomentRange(Moment::fromString('2026-01-01 14:00:00'), Moment::fromString('2026-01-01 16:00:00')),
        ]);

        // -- Act & Assert
        self::assertEquals(new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00')), $collection->first());
        self::assertEquals(new MomentRange(Moment::fromString('2026-01-01 14:00:00'), Moment::fromString('2026-01-01 16:00:00')), $collection->last());
    }

    #[Test]
    public function first_and_last_works_without_elements(): void
    {
        // -- Arrange
        $collection = new MomentRanges([]);

        // -- Act & Assert
        self::assertNull($collection->first());
        self::assertNull($collection->last());
    }
}
