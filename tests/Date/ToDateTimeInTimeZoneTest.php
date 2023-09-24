<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Date */
final class ToDateTimeInTimeZoneTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::toMomentInTimeZone
     */
    public function format_works(
        Moment $expectedResult,
        Date $date,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $date->toMomentInTimeZone($timeZone));
    }

    /**
     * @return array<string, array{
     *   0: Moment,
     *   1: Date,
     *   2: \DateTimeZone,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            '2. october 2022 in Europe/Berlin' => [
                Moment::fromStringInTimeZone('2022-10-02 00:00:00', new \DateTimeZone('Europe/Berlin')),
                Date::fromString('2022-10-02'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            '2. october 2023 in UTC' => [
                Moment::fromStringInTimeZone('2023-10-02 00:00:00', new \DateTimeZone('UTC')),
                Date::fromString('2023-10-02'),
                new \DateTimeZone('UTC'),
            ],
        ];
    }
}
