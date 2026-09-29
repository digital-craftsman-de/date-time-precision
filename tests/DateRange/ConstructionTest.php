<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\DateRange;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\DateRange;
use DigitalCraftsman\DateTimePrecision\Exception\DateRangeStartIsAfterEnd;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(DateRange::class)]
#[CoversClass(DateRangeStartIsAfterEnd::class)]
final class ConstructionTest extends TestCase
{
    #[Test]
    public function construction_works(): void
    {
        // -- Act
        $dateRange = new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-10'));

        // -- Assert
        self::assertEquals(Date::fromString('2026-01-01'), $dateRange->start);
        self::assertEquals(Date::fromString('2026-01-10'), $dateRange->end);
    }

    #[Test]
    public function construction_works_with_single_date(): void
    {
        // -- Act
        $dateRange = new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-01'));

        // -- Assert
        self::assertEquals($dateRange->start, $dateRange->end);
    }

    #[Test]
    public function construction_fails_when_start_is_after_end(): void
    {
        // -- Assert
        $this->expectException(DateRangeStartIsAfterEnd::class);

        // -- Act
        new DateRange(Date::fromString('2026-01-02'), Date::fromString('2026-01-01'));
    }
}
