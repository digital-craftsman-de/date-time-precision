<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\Time;

use DigitalCraftsman\DateTimeParts\Time;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\Time */
final class TimeIsBeforeTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::isBefore
     */
    public function is_before_works(
        bool $expectedResult,
        Time $time,
        Time $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $time->isBefore($comparator));
    }

    /**
     * @return array<string, array{
     *   0: boolean,
     *   1: Time,
     *   2: Time,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            '1 hour after' => [
                false,
                Time::fromString('16:00:00'),
                Time::fromString('15:00:00'),
            ],
            'same time' => [
                false,
                Time::fromString('15:00:00'),
                Time::fromString('15:00:00'),
            ],
            '1 hour before' => [
                true,
                Time::fromString('15:00:00'),
                Time::fromString('16:00:00'),
            ],
            '1 minute before' => [
                true,
                Time::fromString('15:00:00'),
                Time::fromString('15:01:00'),
            ],
            '1 second before' => [
                true,
                Time::fromString('15:00:00'),
                Time::fromString('15:00:01'),
            ],
            '1 millisecond before' => [
                true,
                Time::fromString('15:00:00'),
                Time::fromString('15:00:00.000001'),
            ],
        ];
    }
}
