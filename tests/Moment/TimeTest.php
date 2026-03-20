<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\Time;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Moment::class)]
final class TimeTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProviderForTime')]
    public function time_works(
        Time $expectedResult,
        Moment $dateTime,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $dateTime->time());
    }

    /**
     * @return array<string, array{
     *   0: Time,
     *   1: Moment,
     * }>
     */
    public static function dataProviderForTime(): array
    {
        return [
            'same time in UTC' => [
                Time::fromString('15:00:00'),
                Moment::fromString('2022-10-08 15:00:00'),
            ],
            'time adapted due to time zone difference' => [
                Time::fromString('15:00:00'),
                Moment::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin'))
                    ->toTimeZone(new \DateTimeZone('Europe/Berlin')),
            ],
        ];
    }

    #[Test]
    #[DataProvider('dataProviderForTimeInTimeZone')]
    public function time_in_time_zone_works(
        Time $expectedResult,
        Moment $dateTime,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $dateTime->timeInTimeZone($timeZone));
    }

    /**
     * @return array<string, array{
     *   0: Time,
     *   1: Moment,
     *   2: \DateTimeZone,
     * }>
     */
    public static function dataProviderForTimeInTimeZone(): array
    {
        return [
            'same time in UTC' => [
                Time::fromString('15:00:00'),
                Moment::fromString('2022-10-08 15:00:00'),
                new \DateTimeZone('UTC'),
            ],
            'adapting time for two hours through timezone difference' => [
                Time::fromString('01:00:00'),
                Moment::fromString('2022-10-08 23:00:00'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'same time when timezone was used for creation of datetime' => [
                Time::fromString('15:00:00'),
                Moment::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin')),
                new \DateTimeZone('Europe/Berlin'),
            ],
        ];
    }
}
