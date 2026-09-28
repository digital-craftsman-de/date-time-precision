<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Week;

use DigitalCraftsman\DateTimePrecision\CalendarPeriod;
use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\DateRange;
use DigitalCraftsman\DateTimePrecision\Dates;
use DigitalCraftsman\DateTimePrecision\Exception\CalendarUnitIsNotSupported;
use DigitalCraftsman\DateTimePrecision\Exception\WeekIsBefore;
use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\MomentRange;
use DigitalCraftsman\DateTimePrecision\PeriodLimit;
use DigitalCraftsman\DateTimePrecision\Week;
use DigitalCraftsman\DateTimePrecision\Weeks;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Week::class)]
#[CoversClass(WeekIsBefore::class)]
final class CalendarTest extends TestCase
{
    #[Test]
    public function first_day_last_day_and_dates_works(): void
    {
        // -- Arrange
        $week = Week::fromString('2026-W01');

        // -- Act & Assert
        self::assertEquals(Date::fromString('2025-12-29'), $week->firstDay());
        self::assertEquals(Date::fromString('2026-01-04'), $week->lastDay());
        self::assertEquals(new DateRange(Date::fromString('2025-12-29'), Date::fromString('2026-01-04')), $week->dateRange());
        self::assertEquals(new Dates([
            Date::fromString('2025-12-29'),
            Date::fromString('2025-12-30'),
            Date::fromString('2025-12-31'),
            Date::fromString('2026-01-01'),
            Date::fromString('2026-01-02'),
            Date::fromString('2026-01-03'),
            Date::fromString('2026-01-04'),
        ]), $week->dates());
        self::assertSame('2025-12-29', $week->format('Y-m-d'));
    }

    #[Test]
    #[DataProvider('containsDataProvider')]
    public function contains_works(
        bool $expectedResult,
        string $date,
    ): void {
        // -- Arrange
        $week = Week::fromString('2026-W01');

        // -- Act & Assert
        self::assertSame($expectedResult, $week->contains(Date::fromString($date)));
        self::assertSame(!$expectedResult, $week->notContains(Date::fromString($date)));
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: string,
     * }>
     */
    public static function containsDataProvider(): array
    {
        return [
            'sunday before' => [false, '2025-12-28'],
            'monday' => [true, '2025-12-29'],
            'sunday' => [true, '2026-01-04'],
            'monday after' => [false, '2026-01-05'],
            'same week number in other year' => [false, '2025-01-01'],
        ];
    }

    #[Test]
    public function add_and_subtract_works(): void
    {
        // -- Arrange
        $week = Week::fromString('2026-W52');

        // -- Act & Assert
        self::assertEquals(Week::fromString('2027-W01'), $week->add(CalendarPeriod::weeks(2)));
        self::assertEquals(Week::fromString('2026-W50'), $week->subtract(CalendarPeriod::weeks(2)));
        self::assertEquals(Week::fromString('2026-W53'), $week->next());
        self::assertEquals(Week::fromString('2026-W51'), $week->previous());
        self::assertEquals(Week::fromString('2025-W52'), Week::fromString('2026-W01')->previous());
    }

    #[Test]
    #[DataProvider('unsupportedDataProvider')]
    public function add_and_subtract_fails_with_unsupported_calendar_unit(
        CalendarPeriod $calendarPeriod,
        bool $add,
    ): void {
        // -- Assert
        $this->expectException(CalendarUnitIsNotSupported::class);

        // -- Act
        $add
            ? Week::fromString('2026-W01')->add($calendarPeriod)
            : Week::fromString('2026-W01')->subtract($calendarPeriod);
    }

    /**
     * @return array<string, array{
     *   0: CalendarPeriod,
     *   1: bool,
     * }>
     */
    public static function unsupportedDataProvider(): array
    {
        return [
            'add days' => [CalendarPeriod::days(7), true],
            'subtract months' => [CalendarPeriod::months(1), false],
        ];
    }

    #[Test]
    public function weeks_until_works(): void
    {
        // -- Arrange
        $start = Week::fromString('2025-W52');
        $end = Week::fromString('2026-W02');

        // -- Act & Assert
        self::assertEquals(new Weeks([
            Week::fromString('2025-W52'),
            Week::fromString('2026-W01'),
            Week::fromString('2026-W02'),
        ]), $start->weeksUntil($end));
        self::assertEquals(new Weeks([
            Week::fromString('2025-W52'),
            Week::fromString('2026-W01'),
        ]), $start->weeksUntil($end, PeriodLimit::INCLUDING_START));
        self::assertEquals(new Weeks([
            Week::fromString('2026-W01'),
            Week::fromString('2026-W02'),
        ]), $start->weeksUntil($end, PeriodLimit::INCLUDING_END));
        self::assertEquals(new Weeks([
            Week::fromString('2026-W01'),
        ]), $start->weeksUntil($end, PeriodLimit::EXCLUDING_START_AND_END));
        self::assertEquals(new Weeks([]), $end->weeksUntil($start));
    }

    #[Test]
    public function period_until_works(): void
    {
        // -- Act & Assert
        self::assertEquals(CalendarPeriod::weeks(2), Week::fromString('2025-W51')->periodUntil(Week::fromString('2026-W01')));
        self::assertEquals(CalendarPeriod::weeks(0), Week::fromString('2026-W01')->periodUntil(Week::fromString('2026-W01')));
    }

    #[Test]
    public function period_until_fails_when_week_is_before(): void
    {
        // -- Assert
        $this->expectException(WeekIsBefore::class);

        // -- Act
        Week::fromString('2026-W02')->periodUntil(Week::fromString('2026-W01'));
    }

    #[Test]
    public function to_moment_in_time_zone_works(): void
    {
        // -- Arrange
        $week = Week::fromString('2026-W13');
        $timeZone = new \DateTimeZone('Europe/Berlin');

        // -- Act & Assert
        self::assertTrue(Moment::fromString('2026-03-22 23:00:00')->isEqualTo($week->toMomentInTimeZone($timeZone)));
        self::assertTrue(new MomentRange(
            Moment::fromString('2026-03-22 23:00:00'),
            Moment::fromString('2026-03-29 22:00:00'),
        )->isEqualTo($week->toMomentRangeInTimeZone($timeZone)));
    }
}
