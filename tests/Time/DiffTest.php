<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Time;

use DigitalCraftsman\DateTimePrecision\Time;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Time */
final class DiffTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::diff
     */
    public function diff_works(
        \DateInterval $expectedResult,
        Time $time,
        Time $timeToDiff,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $time->diff($timeToDiff));
    }

    /**
     * @return array<string, array{
     *   0: \DateInterval,
     *   1: Time,
     *   2: Time,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            '5 minutes' => [
                (new \DateTimeImmutable('2022-10-08 15:00:00'))->diff(new \DateTimeImmutable('2022-10-08 15:05:00')),
                Time::fromString('15:00:00'),
                Time::fromString('15:05:00'),
            ],
        ];
    }
}
