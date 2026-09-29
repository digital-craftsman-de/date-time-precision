<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\MomentRange;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Date::class)]
final class ToMomentRangeInTimeZoneTest extends TestCase
{
    #[Test]
    public function to_moment_range_in_time_zone_works(): void
    {
        // -- Act
        $momentRange = Date::fromString('2026-10-25')->toMomentRangeInTimeZone(new \DateTimeZone('Europe/Berlin'));

        // -- Assert
        self::assertTrue(new MomentRange(
            Moment::fromString('2026-10-24 22:00:00'),
            Moment::fromString('2026-10-25 23:00:00'),
        )->isEqualTo($momentRange));
    }
}
