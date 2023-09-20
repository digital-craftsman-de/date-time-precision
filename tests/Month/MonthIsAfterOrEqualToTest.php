<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\Month;

use DigitalCraftsman\DateTimeParts\Month;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\Month */
final class MonthIsAfterOrEqualToTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::isAfterOrEqualTo
     */
    public function is_after_or_equal_to_works(
        bool $expectedResult,
        Month $month,
        Month $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $month->isAfterOrEqualTo($comparator));
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
                Month::fromString('2021-10'),
                Month::fromString('2022-10'),
            ],
            'same month' => [
                true,
                Month::fromString('2022-10'),
                Month::fromString('2022-10'),
            ],
            'next year' => [
                true,
                Month::fromString('2023-10'),
                Month::fromString('2022-10'),
            ],
            'next month' => [
                true,
                Month::fromString('2022-11'),
                Month::fromString('2022-10'),
            ],
        ];
    }
}
