<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\CalendarPeriod;
use DigitalCraftsman\DateTimePrecision\CalendarUnit;
use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Exception\DateIsBefore;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Date::class)]
#[CoversClass(CalendarPeriod::class)]
#[CoversClass(DateIsBefore::class)]
final class PeriodUntilTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function period_until_works(
        CalendarPeriod $expectedResult,
        Date $date,
        Date $until,
        CalendarUnit $calendarUnit,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $date->periodUntil($until, $calendarUnit));
    }

    /**
     * @return array<string, array{
     *   0: CalendarPeriod,
     *   1: Date,
     *   2: Date,
     *   3: CalendarUnit,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'same date' => [
                CalendarPeriod::days(0),
                Date::fromString('2026-03-15'),
                Date::fromString('2026-03-15'),
                CalendarUnit::DAY,
            ],
            'days across months' => [
                CalendarPeriod::days(29),
                Date::fromString('2026-01-31'),
                Date::fromString('2026-03-01'),
                CalendarUnit::DAY,
            ],
            'weeks' => [
                CalendarPeriod::weeks(4),
                Date::fromString('2026-01-31'),
                Date::fromString('2026-03-01'),
                CalendarUnit::WEEK,
            ],
            'months only count full months natively' => [
                CalendarPeriod::months(0),
                Date::fromString('2026-01-31'),
                Date::fromString('2026-03-01'),
                CalendarUnit::MONTH,
            ],
            'quarters' => [
                CalendarPeriod::quarters(5),
                Date::fromString('2026-01-01'),
                Date::fromString('2027-04-01'),
                CalendarUnit::QUARTER,
            ],
            'years from leap day' => [
                CalendarPeriod::years(0),
                Date::fromString('2024-02-29'),
                Date::fromString('2025-02-28'),
                CalendarUnit::YEAR,
            ],
            'years from leap day to first of march' => [
                CalendarPeriod::years(1),
                Date::fromString('2024-02-29'),
                Date::fromString('2025-03-01'),
                CalendarUnit::YEAR,
            ],
        ];
    }

    #[Test]
    public function period_until_fails_when_date_is_before(): void
    {
        // -- Assert
        $this->expectException(DateIsBefore::class);

        // -- Act
        Date::fromString('2026-03-15')->periodUntil(Date::fromString('2026-03-14'), CalendarUnit::DAY);
    }
}
