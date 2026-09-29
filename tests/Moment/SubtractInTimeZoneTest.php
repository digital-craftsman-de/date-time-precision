<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\CalendarPeriod;
use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Moment::class)]
#[CoversClass(CalendarPeriod::class)]
final class SubtractInTimeZoneTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function subtract_in_time_zone_works(
        Moment $expectedResult,
        Moment $moment,
        CalendarPeriod $calendarPeriod,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertTrue($expectedResult->isEqualTo($moment->subtractInTimeZone($calendarPeriod, $timeZone)));
    }

    /**
     * @return array<string, array{
     *   0: Moment,
     *   1: Moment,
     *   2: CalendarPeriod,
     *   3: \DateTimeZone,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'one day across change to winter time keeps local time' => [
                Moment::fromString('2026-10-24 12:00:00'),
                Moment::fromString('2026-10-25 13:00:00'),
                CalendarPeriod::days(1),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'weeks' => [
                Moment::fromStringInTimeZone('2026-01-01 10:00:00', new \DateTimeZone('Europe/Berlin')),
                Moment::fromStringInTimeZone('2026-01-15 10:00:00', new \DateTimeZone('Europe/Berlin')),
                CalendarPeriod::weeks(2),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'years' => [
                Moment::fromStringInTimeZone('2024-06-01 10:00:00', new \DateTimeZone('Europe/Berlin')),
                Moment::fromStringInTimeZone('2026-06-01 10:00:00', new \DateTimeZone('Europe/Berlin')),
                CalendarPeriod::years(2),
                new \DateTimeZone('Europe/Berlin'),
            ],
        ];
    }
}
