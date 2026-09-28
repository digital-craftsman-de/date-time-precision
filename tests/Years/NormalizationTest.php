<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Years;

use DigitalCraftsman\DateTimePrecision\Year;
use DigitalCraftsman\DateTimePrecision\Years;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Years::class)]
final class NormalizationTest extends TestCase
{
    #[Test]
    public function normalize_works(): void
    {
        // -- Arrange
        $collection = new Years([
            new Year(2024),
            new Year(2025),
        ]);

        // -- Act
        $normalizedCollection = $collection->normalize();
        $denormalizedCollection = Years::denormalize($normalizedCollection);

        // -- Assert
        self::assertSame([
            2024,
            2025,
        ], $normalizedCollection);
        self::assertEquals($collection, $denormalizedCollection);
    }

    #[Test]
    public function denormalize_when_not_null_works(): void
    {
        // -- Act & Assert
        self::assertNull(Years::denormalizeWhenNotNull(null));
        self::assertEquals(new Years([]), Years::denormalizeWhenNotNull([]));
    }
}
