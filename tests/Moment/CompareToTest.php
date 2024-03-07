<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Moment */
final class CompareToTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::compareTo
     */
    public function is_before_works(
        int $expectedResult,
        Moment $dateTime,
        Moment $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $dateTime->compareTo($comparator));
    }

    /**
     * @return array<string, array{
     *   0: int,
     *   1: Moment,
     *   2: Moment,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'previous year' => [
                1,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2021-10-08 15:00:00'),
            ],
            'is equal' => [
                0,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2022-10-08 15:00:00'),
            ],
            'next year' => [
                -1,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2023-10-08 15:00:00'),
            ],
            'next month' => [
                -1,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2022-11-08 15:00:00'),
            ],
            'next day' => [
                -1,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2022-10-09 15:00:00'),
            ],
            'next hour' => [
                -1,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2022-10-08 16:00:00'),
            ],
            'next minute' => [
                -1,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2022-10-08 15:01:00'),
            ],
            'next second' => [
                -1,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2022-10-08 15:00:01'),
            ],
            'next millisecond' => [
                -1,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2022-10-08 15:00:00.000001'),
            ],
        ];
    }
}
