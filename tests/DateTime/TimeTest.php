<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\DateTime;

use DigitalCraftsman\DateTimeParts\DateTime;
use DigitalCraftsman\DateTimeParts\Time;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\DateTime */
final class TimeTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProviderForTime
     *
     * @covers ::time
     */
    public function time_works(
        Time $expectedResult,
        DateTime $dateTime,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $dateTime->time());
    }

    /**
     * @return array<string, array{
     *   0: Time,
     *   1: DateTime,
     * }>
     */
    public function dataProviderForTime(): array
    {
        return [
            'same time in UTC' => [
                Time::fromString('15:00:00'),
                DateTime::fromString('2022-10-08 15:00:00'),
            ],
            'time adapted due to time zone difference' => [
                Time::fromString('15:00:00'),
                DateTime::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin'))
                    ->toTimeZone(new \DateTimeZone('Europe/Berlin')),
            ],
        ];
    }

    /**
     * @test
     *
     * @dataProvider dataProviderForTimeInTimeZone
     *
     * @covers ::timeInTimeZone
     */
    public function time_in_time_zone_works(
        Time $expectedResult,
        DateTime $dateTime,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $dateTime->timeInTimeZone($timeZone));
    }

    /**
     * @return array<string, array{
     *   0: Time,
     *   1: DateTime,
     *   2: \DateTimeZone,
     * }>
     */
    public function dataProviderForTimeInTimeZone(): array
    {
        return [
            'same time in UTC' => [
                Time::fromString('15:00:00'),
                DateTime::fromString('2022-10-08 15:00:00'),
                new \DateTimeZone('UTC'),
            ],
            'adapting time for two hours through timezone difference' => [
                Time::fromString('01:00:00'),
                DateTime::fromString('2022-10-08 23:00:00'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'same time when timezone was used for creation of datetime' => [
                Time::fromString('15:00:00'),
                DateTime::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin')),
                new \DateTimeZone('Europe/Berlin'),
            ],
        ];
    }
}
