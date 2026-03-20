<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Time;

use DigitalCraftsman\DateTimePrecision\Time;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Time::class)]
final class NormalizeDenormalizeTest extends TestCase
{
    #[Test]
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
