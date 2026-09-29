<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Months;

use DigitalCraftsman\DateTimePrecision\Month;
use DigitalCraftsman\DateTimePrecision\Months;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Months::class)]
final class NormalizationTest extends TestCase
{
    #[Test]
    public function normalize_works(): void
    {
        // -- Arrange
        $collection = new Months([
            Month::fromString('2026-01'),
            Month::fromString('2026-02'),
        ]);

        // -- Act
        $normalizedCollection = $collection->normalize();
        $denormalizedCollection = Months::denormalize($normalizedCollection);

        // -- Assert
        self::assertSame([
            '2026-01',
            '2026-02',
        ], $normalizedCollection);
        self::assertEquals($collection, $denormalizedCollection);
    }

    #[Test]
    public function denormalize_when_not_null_works(): void
    {
        // -- Act & Assert
        self::assertNull(Months::denormalizeWhenNotNull(null));
        self::assertEquals(new Months([]), Months::denormalizeWhenNotNull([]));
    }
}
