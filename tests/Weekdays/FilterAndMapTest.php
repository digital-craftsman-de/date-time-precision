<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Weekdays;

use DigitalCraftsman\DateTimePrecision\Weekday;
use DigitalCraftsman\DateTimePrecision\Weekdays;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Weekdays::class)]
final class FilterAndMapTest extends TestCase
{
    #[Test]
    public function filter_works(): void
    {
        // -- Arrange
        $collection = new Weekdays([
            Weekday::MONDAY,
            Weekday::TUESDAY,
            Weekday::WEDNESDAY,
        ]);
        $excluded = Weekday::TUESDAY;

        // -- Act
        $filteredCollection = $collection->filter(static fn (Weekday $value): bool => $value->normalize() !== $excluded->normalize());

        // -- Assert
        self::assertEquals(new Weekdays([
            Weekday::MONDAY,
            Weekday::WEDNESDAY,
        ]), $filteredCollection);
    }

    #[Test]
    public function map_works(): void
    {
        // -- Arrange
        $collection = new Weekdays([
            Weekday::MONDAY,
            Weekday::TUESDAY,
        ]);

        // -- Act & Assert
        self::assertSame(
            $collection->normalize(),
            $collection->map(static fn (Weekday $value): mixed => $value->normalize()),
        );
        self::assertSame([], new Weekdays([])->map(static fn (Weekday $value): mixed => $value->normalize()));
    }
}
