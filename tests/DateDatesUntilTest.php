<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\Date */
final class DateDatesUntilTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::datesUntil
     */
    public function dates_until_works(
        array $expectedResult,
        Date $startDate,
        Date $endDate,
        PeriodLimit $periodLimit,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $startDate->datesUntil($endDate, $periodLimit));
    }

    /**
     * @return array<string, array{
     *   0: array<int, Date>,
     *   1: Date,
     *   2: Date,
     *   3: PeriodLimit,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'two days apart with start and end included' => [
                [
                    Date::fromString('2022-08-03'),
                    Date::fromString('2022-08-04'),
                    Date::fromString('2022-08-05'),
                ],
                Date::fromString('2022-08-03'),
                Date::fromString('2022-08-05'),
                PeriodLimit::INCLUDING_START_AND_END,
            ],
            'three days apart with start and end included over the ends of a year' => [
                [
                    Date::fromString('2022-12-30'),
                    Date::fromString('2022-12-31'),
                    Date::fromString('2023-01-01'),
                ],
                Date::fromString('2022-12-30'),
                Date::fromString('2023-01-01'),
                PeriodLimit::INCLUDING_START_AND_END,
            ],
            'two days apart with start included' => [
                [
                    Date::fromString('2022-09-08'),
                    Date::fromString('2022-09-09'),
                ],
                Date::fromString('2022-09-08'),
                Date::fromString('2022-09-10'),
                PeriodLimit::INCLUDING_START,
            ],
            'two days apart with end included' => [
                [
                    Date::fromString('2022-09-09'),
                    Date::fromString('2022-09-10'),
                ],
                Date::fromString('2022-09-08'),
                Date::fromString('2022-09-10'),
                PeriodLimit::INCLUDING_END,
            ],
            'two days apart with start and end excluded' => [
                [
                    Date::fromString('2022-09-09'),
                ],
                Date::fromString('2022-09-08'),
                Date::fromString('2022-09-10'),
                PeriodLimit::EXCLUDING_START_AND_END,
            ],
            'two days apart with start after end' => [
                [],
                Date::fromString('2022-09-11'),
                Date::fromString('2022-09-09'),
                PeriodLimit::INCLUDING_START,
            ],
        ];
    }
}
