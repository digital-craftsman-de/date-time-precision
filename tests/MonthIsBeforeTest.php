<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\Month */
final class MonthIsBeforeTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::isBefore
     */
    public function is_before_works(
        bool $expectedResult,
        Month $month,
        Month $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $month->isBefore($comparator));
    }

    /**
     * @return array<string, array{
     *   0: boolean,
     *   1: Month,
     *   2: Month,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'previous year' => [
                false,
                Month::fromString('2022-10'),
                Month::fromString('2021-10'),
            ],
            'same month' => [
                false,
                Month::fromString('2022-10'),
                Month::fromString('2022-10'),
            ],
            'next year' => [
                true,
                Month::fromString('2022-10'),
                Month::fromString('2023-10'),
            ],
            'next month' => [
                true,
                Month::fromString('2022-10'),
                Month::fromString('2022-11'),
            ],
        ];
    }
}
