<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Month;

use DigitalCraftsman\DateTimePrecision\CalendarPeriod;
use DigitalCraftsman\DateTimePrecision\Month;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Month::class)]
#[CoversClass(CalendarPeriod::class)]
final class NextTest extends TestCase
{
    #[Test]
    public function next_works(): void
    {
        // -- Act & Assert
        self::assertEquals(Month::fromString('2026-02'), Month::fromString('2026-01')->next());
        self::assertEquals(Month::fromString('2027-01'), Month::fromString('2026-12')->next());
    }

    #[Test]
    public function previous_works(): void
    {
        // -- Act & Assert
        self::assertEquals(Month::fromString('2026-02'), Month::fromString('2026-03')->previous());
        self::assertEquals(Month::fromString('2025-12'), Month::fromString('2026-01')->previous());
    }
}
