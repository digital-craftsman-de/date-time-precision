<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Year;

use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\Year;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Year */
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
        Year $year,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $year->toMomentInTimeZone($timeZone));
    }

    /**
     * @return array<string, array{
     *   0: Moment,
     *   1: Year,
     *   2: \DateTimeZone,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'year 2022 in Europe/Berlin' => [
                Moment::fromStringInTimeZone('2022-01-01 00:00:00', new \DateTimeZone('Europe/Berlin')),
                new Year(2022),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'year 2023 in UTC' => [
                Moment::fromStringInTimeZone('2023-01-01 00:00:00', new \DateTimeZone('UTC')),
                new Year(2023),
                new \DateTimeZone('UTC'),
            ],
        ];
    }
}
