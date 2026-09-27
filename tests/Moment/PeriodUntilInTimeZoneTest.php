<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\CalendarPeriod;
use DigitalCraftsman\DateTimePrecision\CalendarUnit;
use DigitalCraftsman\DateTimePrecision\Exception\MomentIsBefore;
use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Moment::class)]
#[CoversClass(CalendarPeriod::class)]
#[CoversClass(MomentIsBefore::class)]
final class PeriodUntilInTimeZoneTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function period_until_in_time_zone_works(
        CalendarPeriod $expectedResult,
        Moment $moment,
        Moment $until,
        CalendarUnit $calendarUnit,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $moment->periodUntilInTimeZone($until, $calendarUnit, $timeZone));
    }

    /**
     * @return array<string, array{
     *   0: CalendarPeriod,
     *   1: Moment,
     *   2: Moment,
     *   3: CalendarUnit,
     *   4: \DateTimeZone,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'same moment' => [
                CalendarPeriod::days(0),
                Moment::fromString('2026-06-01 10:00:00'),
                Moment::fromString('2026-06-01 10:00:00'),
                CalendarUnit::DAY,
                new \DateTimeZone('Europe/Berlin'),
            ],
            'full month in local calendar' => [
                CalendarPeriod::months(1),
                Moment::fromString('2026-01-31 23:30:00'),
                Moment::fromString('2026-02-28 23:30:00'),
                CalendarUnit::MONTH,
                new \DateTimeZone('Europe/Berlin'),
            ],
            'no full month in UTC calendar' => [
                CalendarPeriod::months(0),
                Moment::fromString('2026-01-31 23:30:00'),
                Moment::fromString('2026-02-28 23:30:00'),
                CalendarUnit::MONTH,
                new \DateTimeZone('UTC'),
            ],
            'one day across change to winter time although 25 hours elapsed' => [
                CalendarPeriod::days(1),
                Moment::fromString('2026-10-24 12:00:00'),
                Moment::fromString('2026-10-25 13:00:00'),
                CalendarUnit::DAY,
                new \DateTimeZone('Europe/Berlin'),
            ],
        ];
    }

    #[Test]
    public function period_until_in_time_zone_fails_when_moment_is_before(): void
    {
        // -- Assert
        $this->expectException(MomentIsBefore::class);

        // -- Act
        Moment::fromString('2026-06-01 10:00:00')->periodUntilInTimeZone(
            Moment::fromString('2026-06-01 09:00:00'),
            CalendarUnit::DAY,
            new \DateTimeZone('UTC'),
        );
    }
}
