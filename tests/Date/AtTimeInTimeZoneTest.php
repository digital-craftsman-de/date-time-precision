<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\Time;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Date::class)]
final class AtTimeInTimeZoneTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function at_time_in_time_zone_works(
        Moment $expectedResult,
        Date $date,
        Time $time,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertTrue($expectedResult->isEqualTo($date->atTimeInTimeZone($time, $timeZone)));
    }

    /**
     * @return array<string, array{
     *   0: Moment,
     *   1: Date,
     *   2: Time,
     *   3: \DateTimeZone,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'in UTC' => [
                Moment::fromString('2026-06-01 10:00:00'),
                Date::fromString('2026-06-01'),
                Time::fromString('10:00:00'),
                new \DateTimeZone('UTC'),
            ],
            'in summer time' => [
                Moment::fromString('2026-06-01 08:00:00'),
                Date::fromString('2026-06-01'),
                Time::fromString('10:00:00'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'in winter time' => [
                Moment::fromString('2026-01-15 09:00:00'),
                Date::fromString('2026-01-15'),
                Time::fromString('10:00:00'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'shortly before midnight results in previous date in UTC' => [
                Moment::fromString('2026-01-14 22:30:00'),
                Date::fromString('2026-01-14'),
                Time::fromString('23:30:00'),
                new \DateTimeZone('Europe/Berlin'),
            ],
        ];
    }
}
