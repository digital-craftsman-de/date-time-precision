<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Times;

use DigitalCraftsman\DateTimePrecision\Time;
use DigitalCraftsman\DateTimePrecision\Times;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Times::class)]
final class NormalizationTest extends TestCase
{
    #[Test]
    public function normalize_works(): void
    {
        // -- Arrange
        $collection = new Times([
            new Time(10, 0, 0),
            new Time(11, 0, 0),
        ]);

        // -- Act
        $normalizedCollection = $collection->normalize();
        $denormalizedCollection = Times::denormalize($normalizedCollection);

        // -- Assert
        self::assertSame([
            '10:00:00',
            '11:00:00',
        ], $normalizedCollection);
        self::assertEquals($collection, $denormalizedCollection);
    }

    #[Test]
    public function denormalize_when_not_null_works(): void
    {
        // -- Act & Assert
        self::assertNull(Times::denormalizeWhenNotNull(null));
        self::assertEquals(new Times([]), Times::denormalizeWhenNotNull([]));
    }
}
