<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\Date */
final class DateModifyTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::modify
     */
    public function modify_works(
        Date $expectedResult,
        Date $date,
        string $modifier,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $date->modify($modifier));
    }

    /**
     * @return array<string, array{
     *   0: Date,
     *   1: Date,
     *   2: string,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'subtract one month' => [
                Date::fromString('2022-09-01'),
                Date::fromString('2022-10-01'),
                '- 1 month',
            ],
            'add one month' => [
                Date::fromString('2022-11-01'),
                Date::fromString('2022-10-01'),
                '+ 1 month',
            ],
            'add one day' => [
                Date::fromString('2022-10-15'),
                Date::fromString('2022-10-14'),
                '+ 1 day',
            ],
            // Internal logic of DateTime with "fixing" 2022-02-31
            'subtract one month from the end of march' => [
                Date::fromString('2022-03-03'),
                Date::fromString('2022-03-31'),
                '- 1 month',
            ],
            'add multiple months to skip years' => [
                Date::fromString('2024-04-01'),
                Date::fromString('2022-02-01'),
                '+ 26 months',
            ],
        ];
    }
}
