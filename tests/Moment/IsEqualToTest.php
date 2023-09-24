<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Moment */
final class IsEqualToTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::isEqualTo
     */
    public function is_equal_to_works(
        bool $expectedResult,
        Moment $dateTime,
        Moment $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $dateTime->isEqualTo($comparator));
    }

    /**
     * @return array<string, array{
     *   0: boolean,
     *   1: Moment,
     *   2: Moment,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'is equal' => [
                true,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2022-10-08 15:00:00'),
            ],
            'next year' => [
                false,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2023-10-08 15:00:00'),
            ],
            'next month' => [
                false,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2022-11-08 15:00:00'),
            ],
            'next day' => [
                false,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2022-10-09 15:00:00'),
            ],
            'next hour' => [
                false,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2022-10-08 16:00:00'),
            ],
            'next minute' => [
                false,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2022-10-08 15:01:00'),
            ],
            'next second' => [
                false,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2022-10-08 15:00:01'),
            ],
            'next millisecond' => [
                false,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2022-10-08 15:00:00.000001'),
            ],
        ];
    }
}
