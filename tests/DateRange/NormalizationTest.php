<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\DateRange;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\DateRange;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(DateRange::class)]
final class NormalizationTest extends TestCase
{
    #[Test]
    public function normalize_works(): void
    {
        // -- Arrange
        $dateRange = new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-10'));

        // -- Act
        $normalizedDateRange = $dateRange->normalize();
        $denormalizedDateRange = DateRange::denormalize($normalizedDateRange);

        // -- Assert
        self::assertSame([
            'start' => '2026-01-01',
            'end' => '2026-01-10',
        ], $normalizedDateRange);
        self::assertEquals($dateRange, $denormalizedDateRange);
    }

    #[Test]
    public function denormalize_when_not_null_works(): void
    {
        // -- Act & Assert
        self::assertNull(DateRange::denormalizeWhenNotNull(null));
        self::assertEquals(
            new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-10')),
            DateRange::denormalizeWhenNotNull([
                'start' => '2026-01-01',
                'end' => '2026-01-10',
            ]),
        );
    }
}
