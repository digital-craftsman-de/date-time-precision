<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Month;

use DigitalCraftsman\DateTimePrecision\CalendarPeriod;
use DigitalCraftsman\DateTimePrecision\CalendarUnit;
use DigitalCraftsman\DateTimePrecision\Exception\CalendarUnitIsNotSupported;
use DigitalCraftsman\DateTimePrecision\Exception\MonthIsBefore;
use DigitalCraftsman\DateTimePrecision\Month;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Month::class)]
#[CoversClass(CalendarPeriod::class)]
#[CoversClass(CalendarUnitIsNotSupported::class)]
#[CoversClass(MonthIsBefore::class)]
final class PeriodUntilTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function period_until_works(
        CalendarPeriod $expectedResult,
        Month $month,
        Month $until,
        CalendarUnit $calendarUnit,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $month->periodUntil($until, $calendarUnit));
    }

    /**
     * @return array<string, array{
     *   0: CalendarPeriod,
     *   1: Month,
     *   2: Month,
     *   3: CalendarUnit,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'same month' => [
                CalendarPeriod::months(0),
                Month::fromString('2026-03'),
                Month::fromString('2026-03'),
                CalendarUnit::MONTH,
            ],
            'months across years' => [
                CalendarPeriod::months(15),
                Month::fromString('2025-11'),
                Month::fromString('2027-02'),
                CalendarUnit::MONTH,
            ],
            'quarters' => [
                CalendarPeriod::quarters(5),
                Month::fromString('2025-11'),
                Month::fromString('2027-02'),
                CalendarUnit::QUARTER,
            ],
            'years' => [
                CalendarPeriod::years(1),
                Month::fromString('2025-11'),
                Month::fromString('2027-02'),
                CalendarUnit::YEAR,
            ],
        ];
    }

    #[Test]
    public function period_until_uses_months_by_default(): void
    {
        // -- Act & Assert
        self::assertEquals(
            CalendarPeriod::months(2),
            Month::fromString('2026-01')->periodUntil(Month::fromString('2026-03')),
        );
    }

    #[Test]
    public function period_until_fails_when_month_is_before(): void
    {
        // -- Assert
        $this->expectException(MonthIsBefore::class);

        // -- Act
        Month::fromString('2026-03')->periodUntil(Month::fromString('2026-02'));
    }

    #[Test]
    #[DataProvider('unsupportedDataProvider')]
    public function period_until_fails_with_unsupported_calendar_unit(
        CalendarUnit $calendarUnit,
    ): void {
        // -- Assert
        $this->expectException(CalendarUnitIsNotSupported::class);

        // -- Act
        Month::fromString('2026-01')->periodUntil(Month::fromString('2026-03'), $calendarUnit);
    }

    /**
     * @return array<string, array{
     *   0: CalendarUnit,
     * }>
     */
    public static function unsupportedDataProvider(): array
    {
        return [
            'days' => [CalendarUnit::DAY],
            'weeks' => [CalendarUnit::WEEK],
        ];
    }
}
