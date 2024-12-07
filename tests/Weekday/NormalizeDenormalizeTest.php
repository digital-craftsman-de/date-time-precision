<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Weekday;

use DigitalCraftsman\DateTimePrecision\Weekday;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Weekday
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
        $weekday = Weekday::MONDAY;
        $data = 'MONDAY';

        // -- Act
        $normalized = $weekday->normalize();
        $denormalized = Weekday::denormalize($data);

        // -- Assert
        self::assertSame($data, $normalized);
        self::assertEquals($weekday, $denormalized);
    }
}
