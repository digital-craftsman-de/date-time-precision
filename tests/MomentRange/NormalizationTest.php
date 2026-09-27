<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\MomentRange;

use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\MomentRange;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(MomentRange::class)]
final class NormalizationTest extends TestCase
{
    #[Test]
    public function normalize_works(): void
    {
        // -- Arrange
        $momentRange = new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00'));

        // -- Act
        $normalizedMomentRange = $momentRange->normalize();
        $denormalizedMomentRange = MomentRange::denormalize($normalizedMomentRange);

        // -- Assert
        self::assertSame([
            'start' => '2026-01-01T10:00:00.000000+00:00',
            'end' => '2026-01-01T12:00:00.000000+00:00',
        ], $normalizedMomentRange);
        self::assertTrue($momentRange->isEqualTo($denormalizedMomentRange));
    }

    #[Test]
    public function denormalize_when_not_null_works(): void
    {
        // -- Act
        $momentRange = MomentRange::denormalizeWhenNotNull([
            'start' => '2026-01-01T10:00:00.000000+00:00',
            'end' => '2026-01-01T12:00:00.000000+00:00',
        ]);

        // -- Assert
        self::assertNull(MomentRange::denormalizeWhenNotNull(null));
        self::assertNotNull($momentRange);
        self::assertTrue(Moment::fromString('2026-01-01 12:00:00')->isEqualTo($momentRange->end));
    }
}
