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
final class AddTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function add_works(
        Date $expectedResult,
        Date $date,
        CalendarPeriod $calendarPeriod,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $date->add($calendarPeriod));
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
            'add zero days' => [
                Date::fromString('2026-01-31'),
                Date::fromString('2026-01-31'),
                CalendarPeriod::days(0),
            ],
            'add days across year' => [
                Date::fromString('2027-01-02'),
                Date::fromString('2026-12-30'),
                CalendarPeriod::days(3),
            ],
            'add weeks' => [
                Date::fromString('2026-01-15'),
                Date::fromString('2026-01-01'),
                CalendarPeriod::weeks(2),
            ],
            'add month with native overflow' => [
                Date::fromString('2026-03-03'),
                Date::fromString('2026-01-31'),
                CalendarPeriod::months(1),
            ],
            'add quarter with native overflow' => [
                Date::fromString('2027-03-02'),
                Date::fromString('2026-11-30'),
                CalendarPeriod::quarters(1),
            ],
            'add year to leap day with native overflow' => [
                Date::fromString('2025-03-01'),
                Date::fromString('2024-02-29'),
                CalendarPeriod::years(1),
            ],
        ];
    }
}
