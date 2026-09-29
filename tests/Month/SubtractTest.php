<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Month;

use DigitalCraftsman\DateTimePrecision\CalendarPeriod;
use DigitalCraftsman\DateTimePrecision\Exception\CalendarUnitIsNotSupported;
use DigitalCraftsman\DateTimePrecision\Month;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Month::class)]
#[CoversClass(CalendarPeriod::class)]
#[CoversClass(CalendarUnitIsNotSupported::class)]
final class SubtractTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function subtract_works(
        Month $expectedResult,
        Month $month,
        CalendarPeriod $calendarPeriod,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $month->subtract($calendarPeriod));
    }

    /**
     * @return array<string, array{
     *   0: Month,
     *   1: Month,
     *   2: CalendarPeriod,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'subtract months across year' => [
                Month::fromString('2026-11'),
                Month::fromString('2027-02'),
                CalendarPeriod::months(3),
            ],
            'subtract month from march without overflow' => [
                Month::fromString('2026-02'),
                Month::fromString('2026-03'),
                CalendarPeriod::months(1),
            ],
            'subtract quarters' => [
                Month::fromString('2026-01'),
                Month::fromString('2026-07'),
                CalendarPeriod::quarters(2),
            ],
            'subtract years' => [
                Month::fromString('2026-01'),
                Month::fromString('2028-01'),
                CalendarPeriod::years(2),
            ],
        ];
    }

    #[Test]
    #[DataProvider('unsupportedDataProvider')]
    public function subtract_fails_with_unsupported_calendar_unit(
        CalendarPeriod $calendarPeriod,
    ): void {
        // -- Assert
        $this->expectException(CalendarUnitIsNotSupported::class);

        // -- Act
        Month::fromString('2026-01')->subtract($calendarPeriod);
    }

    /**
     * @return array<string, array{
     *   0: CalendarPeriod,
     * }>
     */
    public static function unsupportedDataProvider(): array
    {
        return [
            'days' => [CalendarPeriod::days(1)],
            'weeks' => [CalendarPeriod::weeks(1)],
        ];
    }
}
