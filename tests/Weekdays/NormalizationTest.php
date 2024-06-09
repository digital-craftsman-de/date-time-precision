<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Weekdays;

use DigitalCraftsman\DateTimePrecision\Weekday;
use DigitalCraftsman\DateTimePrecision\Weekdays;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Weekdays */
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
        $weekdays = new Weekdays([
            Weekday::MONDAY,
            Weekday::TUESDAY,
        ]);

        // -- Act
        $normalizedWeekdays = $weekdays->normalize();
        $denormalizedWeekdays = Weekdays::denormalize($normalizedWeekdays);

        // -- Assert
        self::assertEquals($weekdays, $denormalizedWeekdays);
    }
}
