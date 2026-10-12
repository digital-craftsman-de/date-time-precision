<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\Date;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Date::class)]
final class NormalizeDenormalizeTest extends TestCase
{
    #[Test]
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

    #[Test]
    public function normalize_and_denormalize_works_with_year_before_100(): void
    {
        // -- Arrange
        $date = Date::fromString('0005-03-01');

        // -- Act
        $normalized = $date->normalize();

        // -- Assert
        self::assertSame(5, $date->month->year->year);
        self::assertSame('0005-03-01', $normalized);
        self::assertSame('0005-03-01', (string) $date);
    }
}
