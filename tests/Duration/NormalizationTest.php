<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Duration;

use DigitalCraftsman\DateTimePrecision\Duration;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Duration::class)]
final class NormalizationTest extends TestCase
{
    #[Test]
    public function normalize_works(): void
    {
        // -- Arrange
        $duration = Duration::fromMilliseconds(1_500);

        // -- Act
        $normalizedDuration = $duration->normalize();
        $denormalizedDuration = Duration::denormalize($normalizedDuration);

        // -- Assert
        self::assertSame(1_500_000, $normalizedDuration);
        self::assertEquals($duration, $denormalizedDuration);
    }

    #[Test]
    public function denormalize_when_not_null_works(): void
    {
        // -- Act & Assert
        self::assertNull(Duration::denormalizeWhenNotNull(null));
        self::assertEquals(Duration::fromSeconds(1), Duration::denormalizeWhenNotNull(1_000_000));
    }
}
