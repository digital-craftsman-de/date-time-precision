<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\Month;

use DigitalCraftsman\DateTimeParts\Month;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\Month */
final class IsNotBeforeTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::isNotBefore
     */
    public function is_not_before_works(
        bool $expectedResult,
        Month $month,
        Month $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $month->isNotBefore($comparator));
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
                true,
                Month::fromString('2022-10'),
                Month::fromString('2021-10'),
            ],
            'same month' => [
                true,
                Month::fromString('2022-10'),
                Month::fromString('2022-10'),
            ],
            'next year' => [
                false,
                Month::fromString('2022-10'),
                Month::fromString('2023-10'),
            ],
            'next month' => [
                false,
                Month::fromString('2022-10'),
                Month::fromString('2022-11'),
            ],
        ];
    }
}
