<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\Year;

use DigitalCraftsman\DateTimeParts\Year;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\Year */
final class YearModifyInTimeZoneTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::modifyInTimeZone
     */
    public function format_works(
        Year $expectedResult,
        Year $year,
        string $modify,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $year->modifyInTimeZone($modify, $timeZone));
    }

    /**
     * @return array<string, array{
     *   0: Year,
     *   1: Year,
     *   2: string,
     *   3: \DateTimeZone,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'year 2022 + 1 year in Europe/Berlin' => [
                new Year(2023),
                new Year(2022),
                '+ 1 year',
                new \DateTimeZone('Europe/Berlin'),
            ],
            'year 2023 - 5 years in UTC' => [
                new Year(2018),
                new Year(2023),
                '- 5 years',
                new \DateTimeZone('UTC'),
            ],
        ];
    }
}
