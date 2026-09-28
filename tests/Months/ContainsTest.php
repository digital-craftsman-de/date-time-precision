<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Months;

use DigitalCraftsman\DateTimePrecision\Month;
use DigitalCraftsman\DateTimePrecision\Months;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Months::class)]
final class ContainsTest extends TestCase
{
    #[Test]
    public function contains_works(): void
    {
        // -- Arrange
        $collection = new Months([
            Month::fromString('2026-01'),
            Month::fromString('2026-02'),
        ]);

        // -- Act & Assert
        self::assertTrue($collection->contains(Month::fromString('2026-01')));
        self::assertTrue($collection->contains(Month::fromString('2026-02')));
        self::assertFalse($collection->contains(Month::fromString('2026-03')));
        self::assertFalse(new Months([])->contains(Month::fromString('2026-01')));
    }

    #[Test]
    public function not_contains_works(): void
    {
        // -- Arrange
        $collection = new Months([
            Month::fromString('2026-01'),
            Month::fromString('2026-02'),
        ]);

        // -- Act & Assert
        self::assertFalse($collection->notContains(Month::fromString('2026-01')));
        self::assertTrue($collection->notContains(Month::fromString('2026-03')));
    }
}
