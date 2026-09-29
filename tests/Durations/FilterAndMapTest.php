<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Durations;

use DigitalCraftsman\DateTimePrecision\Duration;
use DigitalCraftsman\DateTimePrecision\Durations;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Durations::class)]
final class FilterAndMapTest extends TestCase
{
    #[Test]
    public function filter_works(): void
    {
        // -- Arrange
        $collection = new Durations([
            Duration::fromMinutes(15),
            Duration::fromMinutes(30),
            Duration::fromMinutes(45),
        ]);
        $excluded = Duration::fromMinutes(30);

        // -- Act
        $filteredCollection = $collection->filter(static fn (Duration $value): bool => $value->normalize() !== $excluded->normalize());

        // -- Assert
        self::assertEquals(new Durations([
            Duration::fromMinutes(15),
            Duration::fromMinutes(45),
        ]), $filteredCollection);
    }

    #[Test]
    public function map_works(): void
    {
        // -- Arrange
        $collection = new Durations([
            Duration::fromMinutes(15),
            Duration::fromMinutes(30),
        ]);

        // -- Act & Assert
        self::assertSame(
            $collection->normalize(),
            $collection->map(static fn (Duration $value): mixed => $value->normalize()),
        );
        self::assertSame([], new Durations([])->map(static fn (Duration $value): mixed => $value->normalize()));
    }
}
