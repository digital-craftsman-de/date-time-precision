<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Time;

use DigitalCraftsman\DateTimePrecision\Time;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Time */
final class IsMidnightTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::isMidnight
     */
    public function is_midnight_works(
        bool $expectedResult,
        Time $time,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $time->isMidnight());
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: Time,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'at midnight' => [
                true,
                Time::fromString('00:00:00'),
            ],
            'not at midnight' => [
                false,
                Time::fromString('15:00:00'),
            ],
        ];
    }
}
