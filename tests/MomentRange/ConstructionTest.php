<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\MomentRange;

use DigitalCraftsman\DateTimePrecision\Exception\MomentRangeStartIsNotBeforeEnd;
use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\MomentRange;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(MomentRange::class)]
#[CoversClass(MomentRangeStartIsNotBeforeEnd::class)]
final class ConstructionTest extends TestCase
{
    #[Test]
    public function construction_works(): void
    {
        // -- Act
        $momentRange = new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 10:00:00.000001'));

        // -- Assert
        self::assertTrue(Moment::fromString('2026-01-01 10:00:00')->isEqualTo($momentRange->start));
        self::assertTrue(Moment::fromString('2026-01-01 10:00:00.000001')->isEqualTo($momentRange->end));
    }

    #[Test]
    public function construction_fails_when_start_is_equal_to_end(): void
    {
        // -- Assert
        $this->expectException(MomentRangeStartIsNotBeforeEnd::class);

        // -- Act
        new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 10:00:00'));
    }

    #[Test]
    public function construction_fails_when_start_is_after_end(): void
    {
        // -- Assert
        $this->expectException(MomentRangeStartIsNotBeforeEnd::class);

        // -- Act
        new MomentRange(Moment::fromString('2026-01-01 11:00:00'), Moment::fromString('2026-01-01 10:00:00'));
    }
}
