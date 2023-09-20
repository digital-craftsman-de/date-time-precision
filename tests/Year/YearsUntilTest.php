<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\Year;

use DigitalCraftsman\DateTimeParts\PeriodLimit;
use DigitalCraftsman\DateTimeParts\Year;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\Year */
final class YearsUntilTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::yearsUntil
     */
    public function years_until_works(
        array $expectedResult,
        Year $startYear,
        Year $endYear,
        PeriodLimit $periodLimit,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $startYear->yearsUntil($endYear, $periodLimit));
    }

    /**
     * @return array<string, array{
     *   0: array<int, Year>,
     *   1: Year,
     *   2: Year,
     *   3: PeriodLimit,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'two years apart with start and end included' => [
                [
                    Year::fromString('2021'),
                    Year::fromString('2022'),
                    Year::fromString('2023'),
                ],
                Year::fromString('2021'),
                Year::fromString('2023'),
                PeriodLimit::INCLUDING_START_AND_END,
            ],
            'two years apart with start included' => [
                [
                    Year::fromString('2022'),
                    Year::fromString('2023'),
                ],
                Year::fromString('2022'),
                Year::fromString('2024'),
                PeriodLimit::INCLUDING_START,
            ],
            'two years apart with end included' => [
                [
                    Year::fromString('2023'),
                    Year::fromString('2024'),
                ],
                Year::fromString('2022'),
                Year::fromString('2024'),
                PeriodLimit::INCLUDING_END,
            ],
            'two years apart with start and end excluded' => [
                [
                    Year::fromString('2023'),
                ],
                Year::fromString('2022'),
                Year::fromString('2024'),
                PeriodLimit::EXCLUDING_START_AND_END,
            ],
            'two years apart with start after end' => [
                [],
                Year::fromString('2024'),
                Year::fromString('2022'),
                PeriodLimit::INCLUDING_START,
            ],
        ];
    }
}
