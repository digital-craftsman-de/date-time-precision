<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Time;

use DigitalCraftsman\DateTimePrecision\Time;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Time */
final class IsNotBeforeOrEqualToTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::isNotBeforeOrEqualTo
     */
    public function is_not_before_or_equal_to_works(
        bool $expectedResult,
        Time $time,
        Time $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $time->isNotBeforeOrEqualTo($comparator));
    }

    /**
     * @return array<string, array{
     *   0: boolean,
     *   1: Time,
     *   2: Time,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            '1 hour after' => [
                true,
                Time::fromString('16:00:00'),
                Time::fromString('15:00:00'),
            ],
            'same time' => [
                false,
                Time::fromString('15:00:00'),
                Time::fromString('15:00:00'),
            ],
            '1 hour before' => [
                false,
                Time::fromString('15:00:00'),
                Time::fromString('16:00:00'),
            ],
            '1 minute before' => [
                false,
                Time::fromString('15:00:00'),
                Time::fromString('15:01:00'),
            ],
            '1 second before' => [
                false,
                Time::fromString('15:00:00'),
                Time::fromString('15:00:01'),
            ],
            '1 millisecond before' => [
                false,
                Time::fromString('15:00:00'),
                Time::fromString('15:00:00.000001'),
            ],
        ];
    }
}
