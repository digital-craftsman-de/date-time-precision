<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Month;

use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\Month;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Month */
final class ToMomentInTimeZoneTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::toMomentInTimeZone
     */
    public function to_moment_in_time_zone_works(
        Moment $expectedResult,
        Month $month,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $month->toMomentInTimeZone($timeZone));
    }

    /**
     * @return array<string, array{
     *   0: Moment,
     *   1: Month,
     *   2: \DateTimeZone,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'october 2022 in Europe/Berlin' => [
                Moment::fromStringInTimeZone('2022-10-01 00:00:00', new \DateTimeZone('Europe/Berlin')),
                Month::fromString('2022-10'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'october 2023 in UTC' => [
                Moment::fromStringInTimeZone('2023-10-01 00:00:00', new \DateTimeZone('UTC')),
                Month::fromString('2023-10'),
                new \DateTimeZone('UTC'),
            ],
        ];
    }
}
