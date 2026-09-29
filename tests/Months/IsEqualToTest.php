<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Months;

use DigitalCraftsman\DateTimePrecision\Month;
use DigitalCraftsman\DateTimePrecision\Months;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Months::class)]
final class IsEqualToTest extends TestCase
{
    #[Test]
    public function is_equal_to_works(): void
    {
        // -- Arrange
        $collection = new Months([
            Month::fromString('2026-01'),
            Month::fromString('2026-02'),
        ]);

        // -- Act & Assert
        self::assertTrue($collection->isEqualTo(new Months([
            Month::fromString('2026-01'),
            Month::fromString('2026-02'),
        ])));
        self::assertTrue($collection->isEqualTo(new Months([
            Month::fromString('2026-02'),
            Month::fromString('2026-01'),
        ])));
        self::assertFalse($collection->isEqualTo(new Months([
            Month::fromString('2026-01'),
        ])));
        self::assertFalse(new Months([
            Month::fromString('2026-01'),
        ])->isEqualTo($collection));
        self::assertFalse($collection->isEqualTo(new Months([
            Month::fromString('2026-01'),
            Month::fromString('2026-03'),
        ])));
        self::assertTrue(new Months([])->isEqualTo(new Months([])));
    }

    #[Test]
    public function is_not_equal_to_works(): void
    {
        // -- Arrange
        $collection = new Months([
            Month::fromString('2026-01'),
            Month::fromString('2026-02'),
        ]);

        // -- Act & Assert
        self::assertFalse($collection->isNotEqualTo(new Months([
            Month::fromString('2026-02'),
            Month::fromString('2026-01'),
        ])));
        self::assertTrue($collection->isNotEqualTo(new Months([
            Month::fromString('2026-01'),
            Month::fromString('2026-03'),
        ])));
    }
}
