<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\Time;

use DigitalCraftsman\DateTimeParts\Time;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\Time */
final class TimeCompareToTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::compareTo
     */
    public function compare_to_works(
        int $expectedResult,
        Time $time,
        Time $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $time->compareTo($comparator));
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
            '1 hour later' => [
                1,
                Time::fromString('2022-10-08 16:00:00'),
                Time::fromString('2021-10-08 15:00:00'),
            ],
            'same time' => [
                0,
                Time::fromString('2022-10-08 15:00:00'),
                Time::fromString('2022-10-08 15:00:00'),
            ],
            '1 hour before' => [
                -1,
                Time::fromString('2022-10-08 15:00:00'),
                Time::fromString('2022-10-08 16:00:00'),
            ],
            '1 minute before' => [
                -1,
                Time::fromString('2022-10-08 15:00:00'),
                Time::fromString('2022-10-08 15:01:00'),
            ],
            '1 second before' => [
                -1,
                Time::fromString('2022-10-08 15:00:00'),
                Time::fromString('2022-10-08 15:00:01'),
            ],
            '1 millisecond before' => [
                -1,
                Time::fromString('2022-10-08 15:00:00'),
                Time::fromString('2022-10-08 15:00:00.000001'),
            ],
        ];
    }
}
