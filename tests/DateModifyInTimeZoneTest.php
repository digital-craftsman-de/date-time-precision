<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\Date */
final class DateModifyInTimeZoneTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::modifyInTimeZone
     */
    public function format_works(
        Date $expectedResult,
        Date $date,
        string $modify,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $date->modifyInTimeZone($modify, $timeZone));
    }

    /**
     * @return array<string, array{
     *   0: Date,
     *   1: Date,
     *   2: string,
     *   3: \DateTimeZone,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            '2. october 2022 + 1 day in Europe/Berlin' => [
                Date::fromString('2022-10-03'),
                Date::fromString('2022-10-02'),
                '+ 1 day',
                new \DateTimeZone('Europe/Berlin'),
            ],
            '2. october 2023 - 15 days in UTC' => [
                Date::fromString('2022-09-17'),
                Date::fromString('2022-10-02'),
                '- 15 days',
                new \DateTimeZone('UTC'),
            ],
        ];
    }
}
