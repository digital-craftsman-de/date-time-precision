<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Year;

use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\MomentRange;
use DigitalCraftsman\DateTimePrecision\Year;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Year::class)]
final class ToMomentRangeInTimeZoneTest extends TestCase
{
    #[Test]
    public function to_moment_range_in_time_zone_works(): void
    {
        // -- Act
        $momentRange = new Year(2026)->toMomentRangeInTimeZone(new \DateTimeZone('Europe/Berlin'));

        // -- Assert
        self::assertTrue(new MomentRange(
            Moment::fromString('2025-12-31 23:00:00'),
            Moment::fromString('2026-12-31 23:00:00'),
        )->isEqualTo($momentRange));
    }
}
