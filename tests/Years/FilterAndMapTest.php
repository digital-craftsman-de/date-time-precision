<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Years;

use DigitalCraftsman\DateTimePrecision\Year;
use DigitalCraftsman\DateTimePrecision\Years;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Years::class)]
final class FilterAndMapTest extends TestCase
{
    #[Test]
    public function filter_works(): void
    {
        // -- Arrange
        $collection = new Years([
            new Year(2024),
            new Year(2025),
            new Year(2026),
        ]);
        $excluded = new Year(2025);

        // -- Act
        $filteredCollection = $collection->filter(static fn (Year $value): bool => $value->normalize() !== $excluded->normalize());

        // -- Assert
        self::assertEquals(new Years([
            new Year(2024),
            new Year(2026),
        ]), $filteredCollection);
    }

    #[Test]
    public function map_works(): void
    {
        // -- Arrange
        $collection = new Years([
            new Year(2024),
            new Year(2025),
        ]);

        // -- Act & Assert
        self::assertSame(
            $collection->normalize(),
            $collection->map(static fn (Year $value): mixed => $value->normalize()),
        );
        self::assertSame([], new Years([])->map(static fn (Year $value): mixed => $value->normalize()));
    }
}
