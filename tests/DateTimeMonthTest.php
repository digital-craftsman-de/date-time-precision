<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\DateTime */
final class DateTimeMonthTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProviderForMonth
     *
     * @covers ::month
     */
    public function month_works(
        Month $expectedResult,
        DateTime $dateTime,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $dateTime->month());
    }

    /**
     * @return array<string, array{
     *   0: Month,
     *   1: DateTime,
     * }>
     */
    public function dataProviderForMonth(): array
    {
        return [
            'same month in UTC' => [
                Month::fromString('2022-10'),
                DateTime::fromString('2022-10-01 00:00:00'),
            ],
            'month the same with same time zone' => [
                Month::fromString('2022-10'),
                DateTime::fromStringInTimeZone('2022-10-08 00:00:00', new \DateTimeZone('Europe/Berlin'))
                    ->toTimeZone(new \DateTimeZone('Europe/Berlin')),
            ],
            'month the different when in different time zone' => [
                Month::fromString('2022-09'),
                DateTime::fromStringInTimeZone('2022-10-01 00:00:00', new \DateTimeZone('Europe/Berlin')),
            ],
        ];
    }

    /**
     * @test
     *
     * @dataProvider dataProviderForMonthInTimeZone
     *
     * @covers ::monthInTimeZone
     */
    public function month_in_time_zone_works(
        Month $expectedResult,
        DateTime $dateTime,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $dateTime->monthInTimeZone($timeZone));
    }

    /**
     * @return array<string, array{
     *   0: Month,
     *   1: DateTime,
     *   2: \DateTimeZone,
     * }>
     */
    public function dataProviderForMonthInTimeZone(): array
    {
        return [
            'same month in UTC' => [
                Month::fromString('2022-10'),
                DateTime::fromString('2022-10-01 00:00:00'),
                new \DateTimeZone('UTC'),
            ],
            'adapting month depending two hours through timezone difference' => [
                Month::fromString('2022-11'),
                DateTime::fromString('2022-10-31 23:00:00'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'same month when timezone was used for creation of datetime' => [
                Month::fromString('2022-10'),
                DateTime::fromStringInTimeZone('2022-10-01 00:00:00', new \DateTimeZone('Europe/Berlin')),
                new \DateTimeZone('Europe/Berlin'),
            ],
        ];
    }
}
