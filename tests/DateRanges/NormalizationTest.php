<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\DateRanges;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\DateRange;
use DigitalCraftsman\DateTimePrecision\DateRanges;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(DateRanges::class)]
final class NormalizationTest extends TestCase
{
    #[Test]
    public function normalize_works(): void
    {
        // -- Arrange
        $collection = new DateRanges([
            new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-10')),
            new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-11')),
        ]);

        // -- Act
        $normalizedCollection = $collection->normalize();
        $denormalizedCollection = DateRanges::denormalize($normalizedCollection);

        // -- Assert
        self::assertSame([
            ['start' => '2026-01-01', 'end' => '2026-01-10'],
            ['start' => '2026-01-01', 'end' => '2026-01-11'],
        ], $normalizedCollection);
        self::assertEquals($collection, $denormalizedCollection);
    }

    #[Test]
    public function denormalize_when_not_null_works(): void
    {
        // -- Act & Assert
        self::assertNull(DateRanges::denormalizeWhenNotNull(null));
        self::assertEquals(new DateRanges([]), DateRanges::denormalizeWhenNotNull([]));
    }
}
