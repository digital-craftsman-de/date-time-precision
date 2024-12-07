<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Weekdays;

use DigitalCraftsman\DateTimePrecision\Weekday;
use DigitalCraftsman\DateTimePrecision\Weekdays;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Weekdays
 */
final class NormalizeDenormalizeTest extends TestCase
{
    /**
     * @test
     *
     * @covers ::normalize
     * @covers ::denormalize
     */
    public function normalize_and_denormalize_works(): void
    {
        // -- Arrange
        $weekdays = new Weekdays([
            Weekday::MONDAY,
            Weekday::TUESDAY,
            Weekday::WEDNESDAY,
        ]);
        $data = [
            'MONDAY',
            'TUESDAY',
            'WEDNESDAY',
        ];

        // -- Act
        $normalized = $weekdays->normalize();
        $denormalized = Weekdays::denormalize($data);

        // -- Assert
        self::assertSame($data, $normalized);
        self::assertEquals($weekdays, $denormalized);
    }
}
