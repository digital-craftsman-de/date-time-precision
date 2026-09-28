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
final class IsEqualToTest extends TestCase
{
    #[Test]
    public function is_equal_to_works(): void
    {
        // -- Arrange
        $collection = new MomentRanges([
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00')),
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 13:00:00')),
        ]);

        // -- Act & Assert
        self::assertTrue($collection->isEqualTo(new MomentRanges([
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00')),
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 13:00:00')),
        ])));
        self::assertTrue($collection->isEqualTo(new MomentRanges([
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 13:00:00')),
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00')),
        ])));
        self::assertFalse($collection->isEqualTo(new MomentRanges([
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00')),
        ])));
        self::assertFalse(new MomentRanges([
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00')),
        ])->isEqualTo($collection));
        self::assertFalse($collection->isEqualTo(new MomentRanges([
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00')),
            new MomentRange(Moment::fromString('2026-01-01 14:00:00'), Moment::fromString('2026-01-01 16:00:00')),
        ])));
        self::assertTrue(new MomentRanges([])->isEqualTo(new MomentRanges([])));
    }

    #[Test]
    public function is_not_equal_to_works(): void
    {
        // -- Arrange
        $collection = new MomentRanges([
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00')),
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 13:00:00')),
        ]);

        // -- Act & Assert
        self::assertFalse($collection->isNotEqualTo(new MomentRanges([
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 13:00:00')),
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00')),
        ])));
        self::assertTrue($collection->isNotEqualTo(new MomentRanges([
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00')),
            new MomentRange(Moment::fromString('2026-01-01 14:00:00'), Moment::fromString('2026-01-01 16:00:00')),
        ])));
    }
}
