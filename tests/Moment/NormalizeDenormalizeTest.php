<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Moment::class)]
final class NormalizeDenormalizeTest extends TestCase
{
    #[Test]
    public function normalize_and_denormalize_works(): void
    {
        // -- Arrange
        $moment = Moment::fromString('2022-10-08 15:30:00.123456');
        $data = '2022-10-08T15:30:00.123456+00:00';

        // -- Act
        $normalized = $moment->normalize();
        $denormalized = Moment::denormalize($data);

        // -- Assert
        self::assertSame($data, $normalized);
        self::assertEquals($moment, $denormalized);
    }
}
