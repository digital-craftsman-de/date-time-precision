<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Dates;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Dates;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Dates::class)]
final class FilterAndMapTest extends TestCase
{
    #[Test]
    public function filter_works(): void
    {
        // -- Arrange
        $collection = new Dates([
            Date::fromString('2026-01-01'),
            Date::fromString('2026-01-02'),
            Date::fromString('2026-01-03'),
        ]);
        $excluded = Date::fromString('2026-01-02');

        // -- Act
        $filteredCollection = $collection->filter(static fn (Date $value): bool => $value->normalize() !== $excluded->normalize());

        // -- Assert
        self::assertEquals(new Dates([
            Date::fromString('2026-01-01'),
            Date::fromString('2026-01-03'),
        ]), $filteredCollection);
    }

    #[Test]
    public function map_works(): void
    {
        // -- Arrange
        $collection = new Dates([
            Date::fromString('2026-01-01'),
            Date::fromString('2026-01-02'),
        ]);

        // -- Act & Assert
        self::assertSame(
            $collection->normalize(),
            $collection->map(static fn (Date $value): mixed => $value->normalize()),
        );
        self::assertSame([], new Dates([])->map(static fn (Date $value): mixed => $value->normalize()));
    }
}
