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
final class AddTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function add_works(
        Month $expectedResult,
        Month $month,
        CalendarPeriod $calendarPeriod,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $month->add($calendarPeriod));
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
            'add months across year' => [
                Month::fromString('2027-02'),
                Month::fromString('2026-11'),
                CalendarPeriod::months(3),
            ],
            'add month to january without overflow' => [
                Month::fromString('2026-02'),
                Month::fromString('2026-01'),
                CalendarPeriod::months(1),
            ],
            'add quarters' => [
                Month::fromString('2026-07'),
                Month::fromString('2026-01'),
                CalendarPeriod::quarters(2),
            ],
            'add years' => [
                Month::fromString('2028-01'),
                Month::fromString('2026-01'),
                CalendarPeriod::years(2),
            ],
        ];
    }

    #[Test]
    #[DataProvider('unsupportedDataProvider')]
    public function add_fails_with_unsupported_calendar_unit(
        CalendarPeriod $calendarPeriod,
    ): void {
        // -- Assert
        $this->expectException(CalendarUnitIsNotSupported::class);

        // -- Act
        Month::fromString('2026-01')->add($calendarPeriod);
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
