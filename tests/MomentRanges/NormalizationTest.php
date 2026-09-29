<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\MomentRanges;

use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\MomentRange;
use DigitalCraftsman\DateTimePrecision\MomentRanges;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(MomentRanges::class)]
final class NormalizationTest extends TestCase
{
    #[Test]
    public function normalize_works(): void
    {
        // -- Arrange
        $collection = new MomentRanges([
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00')),
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 13:00:00')),
        ]);

        // -- Act
        $normalizedCollection = $collection->normalize();
        $denormalizedCollection = MomentRanges::denormalize($normalizedCollection);

        // -- Assert
        self::assertSame([
            ['start' => '2026-01-01T10:00:00.000000+00:00', 'end' => '2026-01-01T12:00:00.000000+00:00'],
            ['start' => '2026-01-01T10:00:00.000000+00:00', 'end' => '2026-01-01T13:00:00.000000+00:00'],
        ], $normalizedCollection);
        self::assertEquals($collection, $denormalizedCollection);
    }

    #[Test]
    public function denormalize_when_not_null_works(): void
    {
        // -- Act & Assert
        self::assertNull(MomentRanges::denormalizeWhenNotNull(null));
        self::assertEquals(new MomentRanges([]), MomentRanges::denormalizeWhenNotNull([]));
    }
}
