<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Month;

use DigitalCraftsman\DateTimePrecision\Month;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Month
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
        $month = Month::fromString('2022-10');
        $data = '2022-10';

        // -- Act
        $normalized = $month->normalize();
        $denormalized = Month::denormalize($data);

        // -- Assert
        self::assertSame($data, $normalized);
        self::assertEquals($month, $denormalized);
    }
}
