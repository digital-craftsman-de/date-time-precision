<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\Year;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Moment */
final class YearTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProviderForYear
     *
     * @covers ::year
     */
    public function year_works(
        Year $expectedResult,
        Moment $dateTime,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $dateTime->year());
    }

    /**
     * @return array<string, array{
     *   0: Year,
     *   1: Moment,
     * }>
     */
    public function dataProviderForYear(): array
    {
        return [
            'same year in UTC' => [
                new Year(2022),
                Moment::fromString('2022-01-01 00:00:00'),
            ],
            'year the same with same time zone' => [
                new Year(2022),
                Moment::fromStringInTimeZone('2022-01-01 00:00:00', new \DateTimeZone('Europe/Berlin'))
                    ->toTimeZone(new \DateTimeZone('Europe/Berlin')),
            ],
            'year is different when in different time zone' => [
                new Year(2021),
                Moment::fromStringInTimeZone('2022-01-01 00:00:00', new \DateTimeZone('Europe/Berlin')),
            ],
        ];
    }

    /**
     * @test
     *
     * @dataProvider dataProviderForYearInTimeZone
     *
     * @covers ::yearInTimeZone
     */
    public function year_in_time_zone_works(
        Year $expectedResult,
        Moment $dateTime,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $dateTime->yearInTimeZone($timeZone));
    }

    /**
     * @return array<string, array{
     *   0: Year,
     *   1: Moment,
     *   2: \DateTimeZone,
     * }>
     */
    public function dataProviderForYearInTimeZone(): array
    {
        return [
            'same year in UTC' => [
                new Year(2022),
                Moment::fromString('2022-01-01 00:00:00'),
                new \DateTimeZone('UTC'),
            ],
            'adapting year depending two hours through timezone difference' => [
                new Year(2023),
                Moment::fromString('2022-12-31 23:00:00'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'same year when timezone was used for creation of datetime' => [
                new Year(2022),
                Moment::fromStringInTimeZone('2022-01-01 00:00:00', new \DateTimeZone('Europe/Berlin')),
                new \DateTimeZone('Europe/Berlin'),
            ],
        ];
    }
}
