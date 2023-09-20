<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\Month;

use DigitalCraftsman\DateTimeParts\Month;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\Month */
final class ModifyTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::modify
     */
    public function modify_works(
        Month $expectedResult,
        Month $month,
        string $modifier,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $month->modify($modifier));
    }

    /**
     * @return array<string, array{
     *   0: Month,
     *   1: Month,
     *   2: string,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'subtract one month' => [
                Month::fromString('2022-09'),
                Month::fromString('2022-10'),
                '- 1 month',
            ],
            'add one month' => [
                Month::fromString('2022-11'),
                Month::fromString('2022-10'),
                '+ 1 month',
            ],
            'stupid but valid modification with one day' => [
                Month::fromString('2022-10'),
                Month::fromString('2022-10'),
                '+ 1 day',
            ],
            'subtract one year on february' => [
                Month::fromString('2021-02'),
                Month::fromString('2022-02'),
                '- 1 year',
            ],
            'add multiple months to skip years' => [
                Month::fromString('2024-04'),
                Month::fromString('2022-02'),
                '+ 26 months',
            ],
        ];
    }
}
