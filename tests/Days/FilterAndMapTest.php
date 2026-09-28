<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Days;

use DigitalCraftsman\DateTimePrecision\Day;
use DigitalCraftsman\DateTimePrecision\Days;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Days::class)]
final class FilterAndMapTest extends TestCase
{
    #[Test]
    public function filter_works(): void
    {
        // -- Arrange
        $collection = new Days([
            new Day(1),
            new Day(15),
            new Day(31),
        ]);
        $excluded = new Day(15);

        // -- Act
        $filteredCollection = $collection->filter(static fn (Day $value): bool => $value->normalize() !== $excluded->normalize());

        // -- Assert
        self::assertEquals(new Days([
            new Day(1),
            new Day(31),
        ]), $filteredCollection);
    }

    #[Test]
    public function map_works(): void
    {
        // -- Arrange
        $collection = new Days([
            new Day(1),
            new Day(15),
        ]);

        // -- Act & Assert
        self::assertSame(
            $collection->normalize(),
            $collection->map(static fn (Day $value): mixed => $value->normalize()),
        );
        self::assertSame([], new Days([])->map(static fn (Day $value): mixed => $value->normalize()));
    }
}
