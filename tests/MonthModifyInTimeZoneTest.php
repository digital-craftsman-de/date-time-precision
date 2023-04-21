<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\Month */
final class MonthModifyInTimeZoneTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::modifyInTimeZone
     */
    public function format_works(
        Month $expectedResult,
        Month $month,
        string $modify,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $month->modifyInTimeZone($modify, $timeZone));
    }

    /**
     * @return array<string, array{
     *   0: Month,
     *   1: Month,
     *   2: string,
     *   3: \DateTimeZone,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'october 2022 + 1 month in Europe/Berlin' => [
                Month::fromString('2022-11'),
                Month::fromString('2022-10'),
                '+ 1 month',
                new \DateTimeZone('Europe/Berlin'),
            ],
            'october 2023 - 15 months in UTC' => [
                Month::fromString('2022-07'),
                Month::fromString('2023-10'),
                '- 15 months',
                new \DateTimeZone('UTC'),
            ],
        ];
    }
}
