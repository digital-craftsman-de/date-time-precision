<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\Weekday;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Moment */
final class WeekdayTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProviderForTime
     *
     * @covers ::weekday
     */
    public function weekday_works(
        Weekday $expectedResult,
        Moment $dateTime,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $dateTime->weekday());
    }

    /**
     * @return array<string, array{
     *   0: Weekday,
     *   1: Moment,
     * }>
     */
    public static function dataProviderForTime(): array
    {
        return [
            'same weekday in UTC' => [
                Weekday::SATURDAY,
                Moment::fromString('2022-10-08 15:00:00'),
            ],
            'weekday adapted due to weekday zone difference' => [
                Weekday::SATURDAY,
                Moment::fromStringInTimeZone('2022-10-08 00:00:00', new \DateTimeZone('Europe/Berlin'))
                    ->toTimeZone(new \DateTimeZone('Europe/Berlin')),
            ],
        ];
    }

    /**
     * @test
     *
     * @dataProvider dataProviderForTimeInTimeZone
     *
     * @covers ::weekdayInTimeZone
     */
    public function weekday_in_weekday_zone_works(
        Weekday $expectedResult,
        Moment $dateTime,
        \DateTimeZone $weekdayZone,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $dateTime->weekdayInTimeZone($weekdayZone));
    }

    /**
     * @return array<string, array{
     *   0: Weekday,
     *   1: Moment,
     *   2: \DateTimeZone,
     * }>
     */
    public static function dataProviderForTimeInTimeZone(): array
    {
        return [
            'same weekday in UTC' => [
                Weekday::SATURDAY,
                Moment::fromString('2022-10-08 15:00:00'),
                new \DateTimeZone('UTC'),
            ],
            'adapting weekday for two hours through timezone difference' => [
                Weekday::SUNDAY,
                Moment::fromString('2022-10-08 23:00:00'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'same weekday when timezone was used for creation of datetime' => [
                Weekday::SATURDAY,
                Moment::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin')),
                new \DateTimeZone('Europe/Berlin'),
            ],
        ];
    }
}
