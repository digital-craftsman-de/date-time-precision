<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\Date;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Date */
final class CompareToTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::compareTo
     */
    public function compare_to_works(
        int $expectedResult,
        Date $date,
        Date $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $date->compareTo($comparator));
    }

    /**
     * @return array<string, array{
     *   0: int,
     *   1: Date,
     *   2: Date,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'previous year' => [
                1,
                Date::fromString('2022-10-08'),
                Date::fromString('2021-10-08'),
            ],
            'same date' => [
                0,
                Date::fromString('2022-10-08'),
                Date::fromString('2022-10-08'),
            ],
            'next year' => [
                -1,
                Date::fromString('2022-10-08'),
                Date::fromString('2023-10-08'),
            ],
            'next month' => [
                -1,
                Date::fromString('2022-10-08'),
                Date::fromString('2022-11-08'),
            ],
            'next day' => [
                -1,
                Date::fromString('2022-10-08'),
                Date::fromString('2022-10-09'),
            ],
        ];
    }
}
