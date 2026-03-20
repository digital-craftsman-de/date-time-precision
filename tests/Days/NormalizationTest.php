<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Days;

use DigitalCraftsman\DateTimePrecision\Day;
use DigitalCraftsman\DateTimePrecision\Days;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Days::class)]
final class NormalizationTest extends TestCase
{
    #[Test]
    public function normalize_works(): void
    {
        // -- Arrange
        $days = new Days([
            new Day(1),
            new Day(15),
        ]);

        // -- Act
        $normalizedDays = $days->normalize();
        $denormalizedDays = Days::denormalize($normalizedDays);

        // -- Assert
        self::assertEquals($days, $denormalizedDays);
    }
}
