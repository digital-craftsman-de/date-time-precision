<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moments;

use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\Moments;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Moments::class)]
final class NormalizationTest extends TestCase
{
    #[Test]
    public function normalize_works(): void
    {
        // -- Arrange
        $collection = new Moments([
            Moment::fromString('2026-01-01 10:00:00'),
            Moment::fromString('2026-01-01 11:00:00'),
        ]);

        // -- Act
        $normalizedCollection = $collection->normalize();
        $denormalizedCollection = Moments::denormalize($normalizedCollection);

        // -- Assert
        self::assertSame([
            '2026-01-01T10:00:00.000000+00:00',
            '2026-01-01T11:00:00.000000+00:00',
        ], $normalizedCollection);
        self::assertEquals($collection, $denormalizedCollection);
    }

    #[Test]
    public function denormalize_when_not_null_works(): void
    {
        // -- Act & Assert
        self::assertNull(Moments::denormalizeWhenNotNull(null));
        self::assertEquals(new Moments([]), Moments::denormalizeWhenNotNull([]));
    }
}
