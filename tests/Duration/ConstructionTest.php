<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Duration;

use DigitalCraftsman\DateTimePrecision\Duration;
use DigitalCraftsman\DateTimePrecision\Exception\InvalidDuration;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Duration::class)]
#[CoversClass(InvalidDuration::class)]
final class ConstructionTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function construction_works(
        int $expectedMicroseconds,
        Duration $duration,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedMicroseconds, $duration->microseconds);
    }

    /**
     * @return array<string, array{
     *   0: int,
     *   1: Duration,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'zero' => [
                0,
                Duration::zero(),
            ],
            'zero through constructor' => [
                0,
                new Duration(0),
            ],
            'from microseconds' => [
                5,
                Duration::fromMicroseconds(5),
            ],
            'from milliseconds' => [
                5_000,
                Duration::fromMilliseconds(5),
            ],
            'from seconds' => [
                5_000_000,
                Duration::fromSeconds(5),
            ],
            'from minutes' => [
                300_000_000,
                Duration::fromMinutes(5),
            ],
            'from hours' => [
                18_000_000_000,
                Duration::fromHours(5),
            ],
        ];
    }

    #[Test]
    public function construction_fails_with_negative_microseconds(): void
    {
        // -- Assert
        $this->expectException(InvalidDuration::class);

        // -- Act
        new Duration(-1);
    }

    #[Test]
    public function construction_fails_with_negative_hours(): void
    {
        // -- Assert
        $this->expectException(InvalidDuration::class);

        // -- Act
        Duration::fromHours(-1);
    }
}
