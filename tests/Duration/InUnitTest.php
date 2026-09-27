<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Duration;

use DigitalCraftsman\DateTimePrecision\Duration;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Duration::class)]
final class InUnitTest extends TestCase
{
    /**
     * @param array{
     *   microseconds: int,
     *   milliseconds: int,
     *   seconds: int,
     *   minutes: int,
     *   hours: int,
     * } $expectedResult
     */
    #[Test]
    #[DataProvider('dataProvider')]
    public function in_unit_works(
        array $expectedResult,
        Duration $duration,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult['microseconds'], $duration->inMicroseconds());
        self::assertSame($expectedResult['milliseconds'], $duration->inMilliseconds());
        self::assertSame($expectedResult['seconds'], $duration->inSeconds());
        self::assertSame($expectedResult['minutes'], $duration->inMinutes());
        self::assertSame($expectedResult['hours'], $duration->inHours());
    }

    /**
     * @return array<string, array{
     *   0: array{
     *     microseconds: int,
     *     milliseconds: int,
     *     seconds: int,
     *     minutes: int,
     *     hours: int,
     *   },
     *   1: Duration,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'zero' => [
                [
                    'microseconds' => 0,
                    'milliseconds' => 0,
                    'seconds' => 0,
                    'minutes' => 0,
                    'hours' => 0,
                ],
                Duration::zero(),
            ],
            'exactly one hour' => [
                [
                    'microseconds' => 3_600_000_000,
                    'milliseconds' => 3_600_000,
                    'seconds' => 3_600,
                    'minutes' => 60,
                    'hours' => 1,
                ],
                Duration::fromHours(1),
            ],
            'one microsecond less than an hour is rounded down' => [
                [
                    'microseconds' => 3_599_999_999,
                    'milliseconds' => 3_599_999,
                    'seconds' => 3_599,
                    'minutes' => 59,
                    'hours' => 0,
                ],
                Duration::fromMicroseconds(3_599_999_999),
            ],
            '90 minutes' => [
                [
                    'microseconds' => 5_400_000_000,
                    'milliseconds' => 5_400_000,
                    'seconds' => 5_400,
                    'minutes' => 90,
                    'hours' => 1,
                ],
                Duration::fromMinutes(90),
            ],
        ];
    }
}
