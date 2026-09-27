<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\CalendarPeriod;

use DigitalCraftsman\DateTimePrecision\CalendarPeriod;
use DigitalCraftsman\DateTimePrecision\CalendarUnit;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(CalendarPeriod::class)]
final class FromDateIntervalTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function from_date_interval_works(
        CalendarPeriod $expectedResult,
        string $start,
        string $end,
        CalendarUnit $calendarUnit,
    ): void {
        // -- Arrange
        $interval = new \DateTimeImmutable($start)->diff(new \DateTimeImmutable($end));

        // -- Act & Assert
        self::assertEquals($expectedResult, CalendarPeriod::fromDateInterval($interval, $calendarUnit));
    }

    /**
     * @return array<string, array{
     *   0: CalendarPeriod,
     *   1: string,
     *   2: string,
     *   3: CalendarUnit,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'days' => [
                CalendarPeriod::days(440),
                '2025-01-01',
                '2026-03-17',
                CalendarUnit::DAY,
            ],
            'weeks are rounded down' => [
                CalendarPeriod::weeks(62),
                '2025-01-01',
                '2026-03-17',
                CalendarUnit::WEEK,
            ],
            'months include years' => [
                CalendarPeriod::months(14),
                '2025-01-01',
                '2026-03-17',
                CalendarUnit::MONTH,
            ],
            'quarters are rounded down' => [
                CalendarPeriod::quarters(4),
                '2025-01-01',
                '2026-03-17',
                CalendarUnit::QUARTER,
            ],
            'quarters at exact boundary' => [
                CalendarPeriod::quarters(5),
                '2025-01-01',
                '2026-04-01',
                CalendarUnit::QUARTER,
            ],
            'years are rounded down' => [
                CalendarPeriod::years(1),
                '2025-01-01',
                '2026-12-31',
                CalendarUnit::YEAR,
            ],
            'months only count full months natively' => [
                CalendarPeriod::months(0),
                '2026-01-31',
                '2026-03-01',
                CalendarUnit::MONTH,
            ],
        ];
    }

    #[Test]
    public function from_date_interval_fails_with_interval_not_created_through_diff(): void
    {
        // -- Assert
        $this->expectException(\InvalidArgumentException::class);

        // -- Act
        CalendarPeriod::fromDateInterval(new \DateInterval('P1D'), CalendarUnit::DAY);
    }
}
