<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\MomentRange;

use DigitalCraftsman\DateTimePrecision\Duration;
use DigitalCraftsman\DateTimePrecision\Exception\DurationIsZero;
use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\MomentRange;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(MomentRange::class)]
#[CoversClass(DurationIsZero::class)]
final class MomentsTest extends TestCase
{
    #[Test]
    public function moments_works_without_end(): void
    {
        // -- Arrange
        $momentRange = new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 11:00:00'));

        // -- Act & Assert
        self::assertSame([
            '2026-01-01T10:00:00.000000+00:00',
            '2026-01-01T10:30:00.000000+00:00',
        ], $momentRange->moments(Duration::fromMinutes(30))->normalize());
    }

    #[Test]
    public function moments_works_with_uneven_step(): void
    {
        // -- Arrange
        $momentRange = new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 11:00:00'));

        // -- Act & Assert
        self::assertSame([
            '2026-01-01T10:00:00.000000+00:00',
            '2026-01-01T10:45:00.000000+00:00',
        ], $momentRange->moments(Duration::fromMinutes(45))->normalize());
    }

    #[Test]
    public function moments_fails_with_zero_step(): void
    {
        // -- Arrange
        $momentRange = new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 11:00:00'));

        // -- Assert
        $this->expectException(DurationIsZero::class);

        // -- Act
        $momentRange->moments(Duration::zero());
    }
}
