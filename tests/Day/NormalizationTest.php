<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Day;

use DigitalCraftsman\DateTimePrecision\Day;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Day */
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
        $day = new Day(15);

        // -- Act
        $normalizedDay = $day->normalize();
        $denormalizedDay = Day::denormalize($normalizedDay);

        // -- Assert
        self::assertEquals($day, $denormalizedDay);
    }
}
