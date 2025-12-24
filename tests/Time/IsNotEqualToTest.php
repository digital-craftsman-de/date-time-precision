<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Time;

use DigitalCraftsman\DateTimePrecision\Time;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Time */
final class IsNotEqualToTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::isNotEqualTo
     */
    public function is_not_equal_to_works(
        bool $expectedResult,
        Time $time,
        Time $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $time->isNotEqualTo($comparator));
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: Time,
     *   2: Time,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            '1 hour before' => [
                true,
                Time::fromString('15:00:00'),
                Time::fromString('16:00:00'),
            ],
            'same time' => [
                false,
                Time::fromString('15:00:00'),
                Time::fromString('15:00:00'),
            ],
            '1 hour later' => [
                true,
                Time::fromString('16:00:00'),
                Time::fromString('15:00:00'),
            ],
            '1 minute later' => [
                true,
                Time::fromString('15:01:00'),
                Time::fromString('15:00:00'),
            ],
            '1 second later' => [
                true,
                Time::fromString('15:00:01'),
                Time::fromString('15:00:00'),
            ],
            '1 millisecond later' => [
                true,
                Time::fromString('15:00:00.000001'),
                Time::fromString('15:00:00'),
            ],
        ];
    }
}
