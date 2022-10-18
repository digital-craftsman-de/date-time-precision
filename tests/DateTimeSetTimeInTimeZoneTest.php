<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\DateTime */
final class DateTimeSetTimeInTimeZoneTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::setTimeInTimeZone
     */
    public function set_time_in_time_zone_works(
        DateTime $expectedResult,
        DateTime $dateTime,
        Time $time,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertTrue($expectedResult->isEqualTo($dateTime->setTimeInTimeZone($time, $timeZone)));
    }

    /**
     * @return array<string, array{
     *   0: DateTime,
     *   1: DateTime,
     *   2: Time,
     *   3: \DateTimeZone,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'set time in UTC' => [
                DateTime::fromString('2022-10-08 14:15:30'),
                DateTime::fromString('2022-10-08 15:00:00'),
                Time::fromString('14:15:30'),
                new \DateTimeZone('UTC'),
            ],
            'set time in Europe/Berlin' => [
                DateTime::fromStringInTimeZone('2022-10-08 14:15:30', new \DateTimeZone('Europe/Berlin')),
                DateTime::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin')),
                Time::fromString('14:15:30'),
                new \DateTimeZone('Europe/Berlin'),
            ],
        ];
    }
}
