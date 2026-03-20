<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Year;

use DigitalCraftsman\DateTimePrecision\Year;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Year::class)]
final class NormalizeDenormalizeTest extends TestCase
{
    #[Test]
    public function normalize_and_denormalize_works(): void
    {
        // -- Arrange
        $year = Year::fromString('2022');
        $data = 2022;

        // -- Act
        $normalized = $year->normalize();
        $denormalized = Year::denormalize($data);

        // -- Assert
        self::assertSame($data, $normalized);
        self::assertEquals($year, $denormalized);
    }
}
