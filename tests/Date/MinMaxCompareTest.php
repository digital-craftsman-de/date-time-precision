<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\Date;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Date::class)]
final class MinMaxCompareTest extends TestCase
{
    #[Test]
    public function min_works(): void
    {
        // -- Act & Assert
        self::assertTrue(Date::fromString('2026-01-09')->isEqualTo(Date::min(Date::fromString('2026-01-15'), Date::fromString('2026-01-09'), Date::fromString('2026-01-21'))));
        self::assertTrue(Date::fromString('2026-01-09')->isEqualTo(Date::min(Date::fromString('2026-01-09'), Date::fromString('2026-01-15'))));
        self::assertTrue(Date::fromString('2026-01-15')->isEqualTo(Date::min(Date::fromString('2026-01-15'))));
    }

    #[Test]
    public function max_works(): void
    {
        // -- Act & Assert
        self::assertTrue(Date::fromString('2026-01-21')->isEqualTo(Date::max(Date::fromString('2026-01-15'), Date::fromString('2026-01-21'), Date::fromString('2026-01-09'))));
        self::assertTrue(Date::fromString('2026-01-21')->isEqualTo(Date::max(Date::fromString('2026-01-21'), Date::fromString('2026-01-15'))));
        self::assertTrue(Date::fromString('2026-01-15')->isEqualTo(Date::max(Date::fromString('2026-01-15'))));
    }

    #[Test]
    public function compare_works_for_sorting(): void
    {
        // -- Arrange
        $values = [Date::fromString('2026-01-15'), Date::fromString('2026-01-21'), Date::fromString('2026-01-09')];

        // -- Act
        usort($values, Date::compare(...));

        // -- Assert
        self::assertEquals([Date::fromString('2026-01-09'), Date::fromString('2026-01-15'), Date::fromString('2026-01-21')], $values);
        self::assertSame(0, Date::compare(Date::fromString('2026-01-15'), Date::fromString('2026-01-15')));
    }
}
