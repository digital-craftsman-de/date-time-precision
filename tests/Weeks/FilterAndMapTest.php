<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Weeks;

use DigitalCraftsman\DateTimePrecision\Week;
use DigitalCraftsman\DateTimePrecision\Weeks;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Weeks::class)]
final class FilterAndMapTest extends TestCase
{
    #[Test]
    public function filter_works(): void
    {
        // -- Arrange
        $collection = new Weeks([
            Week::fromString('2026-W01'),
            Week::fromString('2026-W02'),
            Week::fromString('2026-W03'),
        ]);
        $excluded = Week::fromString('2026-W02');

        // -- Act
        $filteredCollection = $collection->filter(static fn (Week $value): bool => $value->normalize() !== $excluded->normalize());

        // -- Assert
        self::assertEquals(new Weeks([
            Week::fromString('2026-W01'),
            Week::fromString('2026-W03'),
        ]), $filteredCollection);
    }

    #[Test]
    public function map_works(): void
    {
        // -- Arrange
        $collection = new Weeks([
            Week::fromString('2026-W01'),
            Week::fromString('2026-W02'),
        ]);

        // -- Act & Assert
        self::assertSame(
            $collection->normalize(),
            $collection->map(static fn (Week $value): mixed => $value->normalize()),
        );
        self::assertSame([], new Weeks([])->map(static fn (Week $value): mixed => $value->normalize()));
    }
}
