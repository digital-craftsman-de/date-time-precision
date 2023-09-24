<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Time;

use DigitalCraftsman\DateTimePrecision\Time;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Time */
final class IsNotMidnightTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::isNotMidnight
     */
    public function is_not_midnight_works(
        bool $expectedResult,
        Time $time,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $time->isNotMidnight());
    }

    /**
     * @return array<string, array{
     *   0: boolean,
     *   1: Time,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'at not midnight' => [
                true,
                Time::fromString('15:00:00'),
            ],
            'at midnight' => [
                false,
                Time::fromString('00:00:00'),
            ],
        ];
    }
}
