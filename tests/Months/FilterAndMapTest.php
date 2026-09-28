<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Months;

use DigitalCraftsman\DateTimePrecision\Month;
use DigitalCraftsman\DateTimePrecision\Months;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Months::class)]
final class FilterAndMapTest extends TestCase
{
    #[Test]
    public function filter_works(): void
    {
        // -- Arrange
        $collection = new Months([
            Month::fromString('2026-01'),
            Month::fromString('2026-02'),
            Month::fromString('2026-03'),
        ]);
        $excluded = Month::fromString('2026-02');

        // -- Act
        $filteredCollection = $collection->filter(static fn (Month $value): bool => $value->normalize() !== $excluded->normalize());

        // -- Assert
        self::assertEquals(new Months([
            Month::fromString('2026-01'),
            Month::fromString('2026-03'),
        ]), $filteredCollection);
    }

    #[Test]
    public function map_works(): void
    {
        // -- Arrange
        $collection = new Months([
            Month::fromString('2026-01'),
            Month::fromString('2026-02'),
        ]);

        // -- Act & Assert
        self::assertSame(
            $collection->normalize(),
            $collection->map(static fn (Month $value): mixed => $value->normalize()),
        );
        self::assertSame([], new Months([])->map(static fn (Month $value): mixed => $value->normalize()));
    }
}
