<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Time;

use DigitalCraftsman\DateTimePrecision\Time;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Time
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
        $time = Time::fromString('15:45:30');
        $data = '15:45:30';

        // -- Act
        $normalized = $time->normalize();
        $denormalized = Time::denormalize($data);

        // -- Assert
        self::assertSame($data, $normalized);
        self::assertEquals($time, $denormalized);
    }
}
