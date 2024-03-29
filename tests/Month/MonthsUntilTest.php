<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Month;

use DigitalCraftsman\DateTimePrecision\Month;
use DigitalCraftsman\DateTimePrecision\PeriodLimit;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Month */
final class MonthsUntilTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::monthsUntil
     */
    public function months_until_works(
        array $expectedResult,
        Month $startMonth,
        Month $endMonth,
        PeriodLimit $periodLimit,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $startMonth->monthsUntil($endMonth, $periodLimit));
    }

    /**
     * @return array<string, array{
     *   0: array<int, Month>,
     *   1: Month,
     *   2: Month,
     *   3: PeriodLimit,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'two months apart with start and end included' => [
                [
                    Month::fromString('2022-08'),
                    Month::fromString('2022-09'),
                    Month::fromString('2022-10'),
                ],
                Month::fromString('2022-08'),
                Month::fromString('2022-10'),
                PeriodLimit::INCLUDING_START_AND_END,
            ],
            'three months apart with start and end included over the ends of a year' => [
                [
                    Month::fromString('2022-11'),
                    Month::fromString('2022-12'),
                    Month::fromString('2023-01'),
                ],
                Month::fromString('2022-11'),
                Month::fromString('2023-01'),
                PeriodLimit::INCLUDING_START_AND_END,
            ],
            'two months apart with start included' => [
                [
                    Month::fromString('2022-08'),
                    Month::fromString('2022-09'),
                ],
                Month::fromString('2022-08'),
                Month::fromString('2022-10'),
                PeriodLimit::INCLUDING_START,
            ],
            'two months apart with end included' => [
                [
                    Month::fromString('2022-09'),
                    Month::fromString('2022-10'),
                ],
                Month::fromString('2022-08'),
                Month::fromString('2022-10'),
                PeriodLimit::INCLUDING_END,
            ],
            'two months apart with start and end excluded' => [
                [
                    Month::fromString('2022-09'),
                ],
                Month::fromString('2022-08'),
                Month::fromString('2022-10'),
                PeriodLimit::EXCLUDING_START_AND_END,
            ],
            'two months apart with start after end' => [
                [],
                Month::fromString('2022-11'),
                Month::fromString('2022-09'),
                PeriodLimit::INCLUDING_START,
            ],
        ];
    }
}
