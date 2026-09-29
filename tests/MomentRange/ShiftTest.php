<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\MomentRange;

use DigitalCraftsman\DateTimePrecision\CalendarPeriod;
use DigitalCraftsman\DateTimePrecision\Duration;
use DigitalCraftsman\DateTimePrecision\Exception\MomentRangeStartIsNotBeforeEnd;
use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\MomentRange;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(MomentRange::class)]
final class ShiftTest extends TestCase
{
    #[Test]
    public function shift_works(): void
    {
        // -- Arrange
        $momentRange = new MomentRange(Moment::fromString('2026-10-24 10:00:00'), Moment::fromString('2026-10-24 12:00:00'));
        $timeZone = new \DateTimeZone('Europe/Berlin');

        // -- Act & Assert
        self::assertTrue(new MomentRange(
            Moment::fromString('2026-10-25 10:00:00'),
            Moment::fromString('2026-10-25 12:00:00'),
        )->isEqualTo($momentRange->shiftForward(Duration::fromHours(24))));
        self::assertTrue(new MomentRange(
            Moment::fromString('2026-10-23 10:00:00'),
            Moment::fromString('2026-10-23 12:00:00'),
        )->isEqualTo($momentRange->shiftBackward(Duration::fromHours(24))));
        self::assertTrue(new MomentRange(
            Moment::fromString('2026-10-25 11:00:00'),
            Moment::fromString('2026-10-25 13:00:00'),
        )->isEqualTo($momentRange->shiftForwardInTimeZone(CalendarPeriod::days(1), $timeZone)));
        self::assertTrue(new MomentRange(
            Moment::fromString('2026-10-24 10:00:00'),
            Moment::fromString('2026-10-24 12:00:00'),
        )->isEqualTo($momentRange
            ->shiftForwardInTimeZone(CalendarPeriod::days(1), $timeZone)
            ->shiftBackwardInTimeZone(CalendarPeriod::days(1), $timeZone)));
    }

    #[Test]
    public function shift_forward_in_time_zone_fails_when_native_overflow_moves_start_after_end(): void
    {
        // -- Arrange
        $momentRange = new MomentRange(Moment::fromString('2026-01-31 10:00:00'), Moment::fromString('2026-02-01 10:00:00'));

        // -- Assert
        $this->expectException(MomentRangeStartIsNotBeforeEnd::class);

        // -- Act
        $momentRange->shiftForwardInTimeZone(CalendarPeriod::months(1), new \DateTimeZone('UTC'));
    }
}
