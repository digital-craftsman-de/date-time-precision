<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Time;

use DigitalCraftsman\DateTimePrecision\Time;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Time */
final class FormatTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::format
     */
    public function format_works(
        string $expectedResult,
        Time $time,
        string $format,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $time->format($format));
    }

    /**
     * @return array<string, array{
     *   0: string,
     *   1: Time,
     *   2: string,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'format to hour and minute' => [
                '15:00',
                Time::fromString('15:00:00'),
                'H:i',
            ],
            'format time' => [
                '15:00:00',
                Time::fromString('15:00:00'),
                'H:i:s',
            ],
        ];
    }
}
