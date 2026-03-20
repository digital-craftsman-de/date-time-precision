<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Days;

use DigitalCraftsman\DateTimePrecision\Day;
use DigitalCraftsman\DateTimePrecision\Days;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Days */
final class NormalizationTest extends TestCase
{
    /**
     * @test
     *
     * @covers ::normalize
     * @covers ::denormalize
     */
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
