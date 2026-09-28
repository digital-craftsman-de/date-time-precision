<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Times;

use DigitalCraftsman\DateTimePrecision\Time;
use DigitalCraftsman\DateTimePrecision\Times;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Times::class)]
final class FilterAndMapTest extends TestCase
{
    #[Test]
    public function filter_works(): void
    {
        // -- Arrange
        $collection = new Times([
            new Time(10, 0, 0),
            new Time(11, 0, 0),
            new Time(12, 0, 0),
        ]);
        $excluded = new Time(11, 0, 0);

        // -- Act
        $filteredCollection = $collection->filter(static fn (Time $value): bool => $value->normalize() !== $excluded->normalize());

        // -- Assert
        self::assertEquals(new Times([
            new Time(10, 0, 0),
            new Time(12, 0, 0),
        ]), $filteredCollection);
    }

    #[Test]
    public function map_works(): void
    {
        // -- Arrange
        $collection = new Times([
            new Time(10, 0, 0),
            new Time(11, 0, 0),
        ]);

        // -- Act & Assert
        self::assertSame(
            $collection->normalize(),
            $collection->map(static fn (Time $value): mixed => $value->normalize()),
        );
        self::assertSame([], new Times([])->map(static fn (Time $value): mixed => $value->normalize()));
    }
}
