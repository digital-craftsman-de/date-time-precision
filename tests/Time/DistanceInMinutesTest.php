<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Time;

use DigitalCraftsman\DateTimePrecision\Time;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Time */
final class DistanceInMinutesTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::distanceInMinutesTo
     */
    public function distance_in_minutes_to_works(
        int $expectedResult,
        Time $time,
        Time $comparator,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $time->distanceInMinutesTo($comparator));
    }

    /**
     * @return array<string, array{
     *   0: int,
     *   1: Time,
     *   2: Time,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            '59 minutes later' => [
                59,
                Time::fromString('15:00:00'),
                Time::fromString('15:59:00'),
            ],
            '2 hours and 15 minutes later' => [
                2 * 60 + 15,
                Time::fromString('15:00:00'),
                Time::fromString('17:15:00'),
            ],
            // When the time is earlier, then the difference is still positive
            'difference to an earlier time' => [
                20 * 60,
                Time::fromString('22:00:00'),
                Time::fromString('02:00:00'),
            ],
        ];
    }
}
