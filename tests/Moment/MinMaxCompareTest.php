<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Moment::class)]
final class MinMaxCompareTest extends TestCase
{
    #[Test]
    public function min_works(): void
    {
        // -- Act & Assert
        self::assertTrue(Moment::fromString('2026-01-10 09:59:59.999999')->isEqualTo(Moment::min(Moment::fromString('2026-01-10 11:00:00'), Moment::fromString('2026-01-10 09:59:59.999999'), Moment::fromString('2026-01-10 12:00:00.000001'))));
        self::assertTrue(Moment::fromString('2026-01-10 09:59:59.999999')->isEqualTo(Moment::min(Moment::fromString('2026-01-10 09:59:59.999999'), Moment::fromString('2026-01-10 11:00:00'))));
        self::assertTrue(Moment::fromString('2026-01-10 11:00:00')->isEqualTo(Moment::min(Moment::fromString('2026-01-10 11:00:00'))));
    }

    #[Test]
    public function max_works(): void
    {
        // -- Act & Assert
        self::assertTrue(Moment::fromString('2026-01-10 12:00:00.000001')->isEqualTo(Moment::max(Moment::fromString('2026-01-10 11:00:00'), Moment::fromString('2026-01-10 12:00:00.000001'), Moment::fromString('2026-01-10 09:59:59.999999'))));
        self::assertTrue(Moment::fromString('2026-01-10 12:00:00.000001')->isEqualTo(Moment::max(Moment::fromString('2026-01-10 12:00:00.000001'), Moment::fromString('2026-01-10 11:00:00'))));
        self::assertTrue(Moment::fromString('2026-01-10 11:00:00')->isEqualTo(Moment::max(Moment::fromString('2026-01-10 11:00:00'))));
    }

    #[Test]
    public function compare_works_for_sorting(): void
    {
        // -- Arrange
        $values = [Moment::fromString('2026-01-10 11:00:00'), Moment::fromString('2026-01-10 12:00:00.000001'), Moment::fromString('2026-01-10 09:59:59.999999')];

        // -- Act
        usort($values, Moment::compare(...));

        // -- Assert
        self::assertEquals([Moment::fromString('2026-01-10 09:59:59.999999'), Moment::fromString('2026-01-10 11:00:00'), Moment::fromString('2026-01-10 12:00:00.000001')], $values);
        self::assertSame(0, Moment::compare(Moment::fromString('2026-01-10 11:00:00'), Moment::fromString('2026-01-10 11:00:00')));
    }
}
