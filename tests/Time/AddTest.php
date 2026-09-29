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
final class AddTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function add_works(
        Time $expectedResult,
        Time $time,
        Duration $duration,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $time->add($duration));
    }

    /**
     * @return array<string, array{
     *   0: Time,
     *   1: Time,
     *   2: Duration,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'add zero' => [
                new Time(10, 0, 0),
                new Time(10, 0, 0),
                Duration::zero(),
            ],
            'add minutes' => [
                new Time(11, 30, 0),
                new Time(10, 0, 0),
                Duration::fromMinutes(90),
            ],
            'add microsecond across second' => [
                new Time(12, 0, 1, 0),
                new Time(12, 0, 0, 999_999),
                Duration::fromMicroseconds(1),
            ],
            'add small microseconds' => [
                new Time(12, 0, 0, 10),
                new Time(12, 0, 0, 5),
                Duration::fromMicroseconds(5),
            ],
            'wraps around midnight' => [
                new Time(1, 0, 0),
                new Time(23, 0, 0),
                Duration::fromHours(2),
            ],
            'wraps around multiple days' => [
                new Time(11, 0, 0),
                new Time(10, 0, 0),
                Duration::fromHours(49),
            ],
        ];
    }
}
