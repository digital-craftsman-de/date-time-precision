<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\Month;
use DigitalCraftsman\DateTimePrecision\Time;
use DigitalCraftsman\DateTimePrecision\Weekday;
use DigitalCraftsman\DateTimePrecision\Year;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Moment */
final class IsNotAfterInTimeZoneTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::isNotAfterInTimeZone
     */
    public function is_not_after_in_time_zone_works(
        bool $expectedResult,
        Moment $moment,
        Time | Weekday | Date | Month | Year $comparator,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $moment->isNotAfterInTimeZone($comparator, $timeZone));
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: Moment,
     *   2: Time | Weekday | Date | Month | Year,
     *   3: \DateTimeZone,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'moment before time' => [
                true,
                Moment::fromStringInTimeZone('2022-10-08 14:55:00', new \DateTimeZone('Europe/Berlin')),
                Time::fromString('15:00:00'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'moment same time' => [
                true,
                Moment::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin')),
                Time::fromString('15:00:00'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'moment after time' => [
                false,
                Moment::fromStringInTimeZone('2022-10-08 15:05:00', new \DateTimeZone('Europe/Berlin')),
                Time::fromString('15:00:00'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'moment before weekday' => [
                true,
                Moment::fromStringInTimeZone('2022-10-07 15:00:00', new \DateTimeZone('Europe/Berlin')),
                Weekday::SATURDAY,
                new \DateTimeZone('Europe/Berlin'),
            ],
            'moment same weekday' => [
                true,
                Moment::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin')),
                Weekday::SATURDAY,
                new \DateTimeZone('Europe/Berlin'),
            ],
            'moment after weekday' => [
                false,
                Moment::fromStringInTimeZone('2022-10-09 15:00:00', new \DateTimeZone('Europe/Berlin')),
                Weekday::SATURDAY,
                new \DateTimeZone('Europe/Berlin'),
            ],
            'moment before date' => [
                true,
                Moment::fromStringInTimeZone('2022-10-07 15:00:00', new \DateTimeZone('Europe/Berlin')),
                Date::fromString('2022-10-08'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'moment same date' => [
                true,
                Moment::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin')),
                Date::fromString('2022-10-08'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'moment after date' => [
                false,
                Moment::fromStringInTimeZone('2022-10-09 15:00:00', new \DateTimeZone('Europe/Berlin')),
                Date::fromString('2022-10-08'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'moment before month' => [
                true,
                Moment::fromStringInTimeZone('2022-09-08 15:00:00', new \DateTimeZone('Europe/Berlin')),
                Month::fromString('2022-10'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'moment same month' => [
                true,
                Moment::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin')),
                Month::fromString('2022-10'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'moment after month' => [
                false,
                Moment::fromStringInTimeZone('2022-11-08 15:00:00', new \DateTimeZone('Europe/Berlin')),
                Month::fromString('2022-10'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'moment before year' => [
                true,
                Moment::fromStringInTimeZone('2021-10-08 15:00:00', new \DateTimeZone('Europe/Berlin')),
                Year::fromString('2022'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'moment same year' => [
                true,
                Moment::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin')),
                Year::fromString('2022'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'moment after year' => [
                false,
                Moment::fromStringInTimeZone('2023-10-08 15:00:00', new \DateTimeZone('Europe/Berlin')),
                Year::fromString('2022'),
                new \DateTimeZone('Europe/Berlin'),
            ],
        ];
    }
}
