<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\MomentRange;

use DigitalCraftsman\DateTimePrecision\Duration;
use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\MomentRange;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(MomentRange::class)]
final class DurationTest extends TestCase
{
    #[Test]
    public function duration_works(): void
    {
        // -- Arrange
        $momentRange = new MomentRange(
            Moment::fromStringInTimeZone('2026-10-25 01:30:00', new \DateTimeZone('Europe/Berlin')),
            Moment::fromStringInTimeZone('2026-10-25 03:30:00', new \DateTimeZone('Europe/Berlin')),
        );

        // -- Act & Assert
        self::assertEquals(Duration::fromHours(3), $momentRange->duration());
    }
}
