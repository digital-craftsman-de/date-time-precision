<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\ValueObject;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\ValueObject\Time */
final class TimeIsNotEqualToTest extends TestCase
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
     *   0: boolean,
     *   1: Time,
     *   2: Time,
     * }>
     */
    public function dataProvider(): array
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
