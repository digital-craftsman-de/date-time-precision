<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Day;
use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Moment::class)]
final class DayTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProviderForDay')]
    public function day_works(
        Day $expectedResult,
        Moment $dateTime,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $dateTime->day());
    }

    /**
     * @return array<string, array{
     *   0: Day,
     *   1: Moment,
     * }>
     */
    public static function dataProviderForDay(): array
    {
        return [
            'same day in UTC' => [
                new Day(1),
                Moment::fromString('2022-01-01 00:00:00'),
            ],
            'day the same with same time zone' => [
                new Day(8),
                Moment::fromStringInTimeZone('2022-10-08 00:00:00', new \DateTimeZone('Europe/Berlin'))
                    ->toTimeZone(new \DateTimeZone('Europe/Berlin')),
            ],
            'day is different when in different time zone' => [
                new Day(31),
                Moment::fromStringInTimeZone('2022-01-01 00:00:00', new \DateTimeZone('Europe/Berlin')),
            ],
        ];
    }

    #[Test]
    #[DataProvider('dataProviderForDayInTimeZone')]
    public function day_in_time_zone_works(
        Day $expectedResult,
        Moment $dateTime,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $dateTime->dayInTimeZone($timeZone));
    }

    /**
     * @return array<string, array{
     *   0: Day,
     *   1: Moment,
     *   2: \DateTimeZone,
     * }>
     */
    public static function dataProviderForDayInTimeZone(): array
    {
        return [
            'same day in UTC' => [
                new Day(1),
                Moment::fromString('2022-01-01 00:00:00'),
                new \DateTimeZone('UTC'),
            ],
            'adapting day through timezone difference' => [
                new Day(1),
                Moment::fromString('2022-12-31 23:00:00'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'same day when timezone was used for creation of datetime' => [
                new Day(1),
                Moment::fromStringInTimeZone('2022-01-01 00:00:00', new \DateTimeZone('Europe/Berlin')),
                new \DateTimeZone('Europe/Berlin'),
            ],
        ];
    }
}
