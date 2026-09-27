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
final class AddInTimeZoneTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function add_in_time_zone_works(
        Moment $expectedResult,
        Moment $moment,
        CalendarPeriod $calendarPeriod,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertTrue($expectedResult->isEqualTo($moment->addInTimeZone($calendarPeriod, $timeZone)));
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
                Moment::fromString('2026-10-25 13:00:00'),
                Moment::fromString('2026-10-24 12:00:00'),
                CalendarPeriod::days(1),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'one day across change to summer time keeps local time' => [
                Moment::fromString('2026-03-29 11:00:00'),
                Moment::fromString('2026-03-28 12:00:00'),
                CalendarPeriod::days(1),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'one day in UTC' => [
                Moment::fromString('2026-10-25 12:00:00'),
                Moment::fromString('2026-10-24 12:00:00'),
                CalendarPeriod::days(1),
                new \DateTimeZone('UTC'),
            ],
            'month with native overflow in local calendar' => [
                Moment::fromStringInTimeZone('2026-03-03 00:30:00', new \DateTimeZone('Europe/Berlin')),
                Moment::fromStringInTimeZone('2026-01-31 00:30:00', new \DateTimeZone('Europe/Berlin')),
                CalendarPeriod::months(1),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'quarter' => [
                Moment::fromStringInTimeZone('2026-04-15 10:00:00', new \DateTimeZone('Europe/Berlin')),
                Moment::fromStringInTimeZone('2026-01-15 10:00:00', new \DateTimeZone('Europe/Berlin')),
                CalendarPeriod::quarters(1),
                new \DateTimeZone('Europe/Berlin'),
            ],
        ];
    }
}
