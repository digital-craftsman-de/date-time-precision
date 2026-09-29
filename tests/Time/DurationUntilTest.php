<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Time;

use DigitalCraftsman\DateTimePrecision\Duration;
use DigitalCraftsman\DateTimePrecision\Time;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Time::class)]
#[CoversClass(Duration::class)]
final class DurationUntilTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function duration_until_works(
        Duration $expectedResult,
        Time $time,
        Time $until,
    ): void {
        // -- Act
        $duration = $time->durationUntil($until);

        // -- Assert
        self::assertEquals($expectedResult, $duration);
        self::assertEquals($until, $time->add($duration));
    }

    /**
     * @return array<string, array{
     *   0: Duration,
     *   1: Time,
     *   2: Time,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'same time' => [
                Duration::zero(),
                new Time(10, 0, 0),
                new Time(10, 0, 0),
            ],
            'minutes' => [
                Duration::fromMinutes(90),
                new Time(10, 0, 0),
                new Time(11, 30, 0),
            ],
            'microseconds across seconds' => [
                Duration::fromMilliseconds(1_200),
                new Time(0, 0, 0, 900_000),
                new Time(0, 0, 2, 100_000),
            ],
            'small microseconds' => [
                Duration::fromMicroseconds(5),
                new Time(12, 0, 0),
                new Time(12, 0, 0, 5),
            ],
            'wraps around midnight' => [
                Duration::fromHours(2),
                new Time(23, 0, 0),
                new Time(1, 0, 0),
            ],
            'wraps around nearly a full day' => [
                Duration::fromMicroseconds(86_399_999_999),
                new Time(10, 0, 0, 1),
                new Time(10, 0, 0),
            ],
        ];
    }
}
