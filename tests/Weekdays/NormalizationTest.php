<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Weekdays;

use DigitalCraftsman\DateTimePrecision\Weekday;
use DigitalCraftsman\DateTimePrecision\Weekdays;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Weekdays::class)]
final class NormalizationTest extends TestCase
{
    /**
     * @test
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
