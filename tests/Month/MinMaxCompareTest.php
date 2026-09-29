<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Month;

use DigitalCraftsman\DateTimePrecision\Month;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Month::class)]
final class MinMaxCompareTest extends TestCase
{
    #[Test]
    public function min_works(): void
    {
        // -- Act & Assert
        self::assertTrue(Month::fromString('2026-02')->isEqualTo(Month::min(Month::fromString('2026-04'), Month::fromString('2026-02'), Month::fromString('2026-07'))));
        self::assertTrue(Month::fromString('2026-02')->isEqualTo(Month::min(Month::fromString('2026-02'), Month::fromString('2026-04'))));
        self::assertTrue(Month::fromString('2026-04')->isEqualTo(Month::min(Month::fromString('2026-04'))));
    }

    #[Test]
    public function max_works(): void
    {
        // -- Act & Assert
        self::assertTrue(Month::fromString('2026-07')->isEqualTo(Month::max(Month::fromString('2026-04'), Month::fromString('2026-07'), Month::fromString('2026-02'))));
        self::assertTrue(Month::fromString('2026-07')->isEqualTo(Month::max(Month::fromString('2026-07'), Month::fromString('2026-04'))));
        self::assertTrue(Month::fromString('2026-04')->isEqualTo(Month::max(Month::fromString('2026-04'))));
    }

    #[Test]
    public function compare_works_for_sorting(): void
    {
        // -- Arrange
        $values = [Month::fromString('2026-04'), Month::fromString('2026-07'), Month::fromString('2026-02')];

        // -- Act
        usort($values, Month::compare(...));

        // -- Assert
        self::assertEquals([Month::fromString('2026-02'), Month::fromString('2026-04'), Month::fromString('2026-07')], $values);
        self::assertSame(0, Month::compare(Month::fromString('2026-04'), Month::fromString('2026-04')));
    }
}
