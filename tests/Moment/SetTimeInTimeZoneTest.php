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
final class SetTimeInTimeZoneTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function set_time_in_time_zone_works(
        Moment $expectedResult,
        Moment $dateTime,
        Time $time,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertTrue($expectedResult->isEqualTo($dateTime->setTimeInTimeZone($time, $timeZone)));
    }

    /**
     * @return array<string, array{
     *   0: Moment,
     *   1: Moment,
     *   2: Time,
     *   3: \DateTimeZone,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'set time in UTC' => [
                Moment::fromString('2022-10-08 14:15:30'),
                Moment::fromString('2022-10-08 15:00:00'),
                Time::fromString('14:15:30'),
                new \DateTimeZone('UTC'),
            ],
            'set time in Europe/Berlin' => [
                Moment::fromStringInTimeZone('2022-10-08 14:15:30', new \DateTimeZone('Europe/Berlin')),
                Moment::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin')),
                Time::fromString('14:15:30'),
                new \DateTimeZone('Europe/Berlin'),
            ],
        ];
    }
}
