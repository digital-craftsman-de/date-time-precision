<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Month;

use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\MomentRange;
use DigitalCraftsman\DateTimePrecision\Month;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Month::class)]
final class ToMomentRangeInTimeZoneTest extends TestCase
{
    #[Test]
    public function to_moment_range_in_time_zone_works(): void
    {
        // -- Act
        $momentRange = Month::fromString('2026-10')->toMomentRangeInTimeZone(new \DateTimeZone('Europe/Berlin'));

        // -- Assert
        self::assertTrue(new MomentRange(
            Moment::fromString('2026-09-30 22:00:00'),
            Moment::fromString('2026-10-31 23:00:00'),
        )->isEqualTo($momentRange));
    }
}
