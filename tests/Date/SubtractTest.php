<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\CalendarPeriod;
use DigitalCraftsman\DateTimePrecision\Date;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Date::class)]
#[CoversClass(CalendarPeriod::class)]
final class SubtractTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function subtract_works(
        Date $expectedResult,
        Date $date,
        CalendarPeriod $calendarPeriod,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $date->subtract($calendarPeriod));
    }

    /**
     * @return array<string, array{
     *   0: Date,
     *   1: Date,
     *   2: CalendarPeriod,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'subtract days across year' => [
                Date::fromString('2026-12-30'),
                Date::fromString('2027-01-02'),
                CalendarPeriod::days(3),
            ],
            'subtract weeks' => [
                Date::fromString('2026-01-01'),
                Date::fromString('2026-01-15'),
                CalendarPeriod::weeks(2),
            ],
            'subtract month with native overflow' => [
                Date::fromString('2026-03-03'),
                Date::fromString('2026-03-31'),
                CalendarPeriod::months(1),
            ],
            'subtract quarters' => [
                Date::fromString('2025-09-15'),
                Date::fromString('2026-03-15'),
                CalendarPeriod::quarters(2),
            ],
            'subtract years' => [
                Date::fromString('2016-03-15'),
                Date::fromString('2026-03-15'),
                CalendarPeriod::years(10),
            ],
        ];
    }
}
