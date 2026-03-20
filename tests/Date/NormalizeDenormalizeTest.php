<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\Date;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Date::class)]
final class NormalizeDenormalizeTest extends TestCase
{
    /**
     * @test
     */
    public function normalize_and_denormalize_works(): void
    {
        // -- Arrange
        $date = Date::fromString('2022-10-08');
        $data = '2022-10-08';

        // -- Act
        $normalized = $date->normalize();
        $denormalized = Date::denormalize($data);

        // -- Assert
        self::assertSame($data, $normalized);
        self::assertEquals($date, $denormalized);
    }
}
