<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Durations;

use DigitalCraftsman\DateTimePrecision\Duration;
use DigitalCraftsman\DateTimePrecision\Durations;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Durations::class)]
final class NormalizationTest extends TestCase
{
    #[Test]
    public function normalize_works(): void
    {
        // -- Arrange
        $collection = new Durations([
            Duration::fromMinutes(15),
            Duration::fromMinutes(30),
        ]);

        // -- Act
        $normalizedCollection = $collection->normalize();
        $denormalizedCollection = Durations::denormalize($normalizedCollection);

        // -- Assert
        self::assertSame([
            900_000_000,
            1_800_000_000,
        ], $normalizedCollection);
        self::assertEquals($collection, $denormalizedCollection);
    }

    #[Test]
    public function denormalize_when_not_null_works(): void
    {
        // -- Act & Assert
        self::assertNull(Durations::denormalizeWhenNotNull(null));
        self::assertEquals(new Durations([]), Durations::denormalizeWhenNotNull([]));
    }
}
