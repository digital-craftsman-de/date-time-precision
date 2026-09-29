<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Recurrences;

use DigitalCraftsman\DateTimePrecision\Recurrence;
use DigitalCraftsman\DateTimePrecision\Recurrences;
use DigitalCraftsman\DateTimePrecision\Weekday;
use DigitalCraftsman\DateTimePrecision\Weekdays;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Recurrences::class)]
final class NormalizationTest extends TestCase
{
    #[Test]
    public function normalize_works(): void
    {
        // -- Arrange
        $collection = new Recurrences([
            Recurrence::daily(),
            Recurrence::weekly(new Weekdays([Weekday::MONDAY])),
        ]);

        // -- Act
        $normalizedCollection = $collection->normalize();
        $denormalizedCollection = Recurrences::denormalize($normalizedCollection);

        // -- Assert
        self::assertSame([
            ['frequency' => 'DAILY', 'weekdays' => null, 'days' => null],
            ['frequency' => 'WEEKLY', 'weekdays' => ['MONDAY'], 'days' => null],
        ], $normalizedCollection);
        self::assertEquals($collection, $denormalizedCollection);
    }

    #[Test]
    public function denormalize_when_not_null_works(): void
    {
        // -- Act & Assert
        self::assertNull(Recurrences::denormalizeWhenNotNull(null));
        self::assertEquals(new Recurrences([]), Recurrences::denormalizeWhenNotNull([]));
    }
}
