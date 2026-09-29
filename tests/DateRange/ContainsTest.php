<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\DateRange;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\DateRange;
use DigitalCraftsman\DateTimePrecision\PeriodLimit;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(DateRange::class)]
final class ContainsTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function contains_works(
        bool $expectedResult,
        string $date,
    ): void {
        // -- Arrange
        $dateRange = new DateRange(Date::fromString('2026-01-10'), Date::fromString('2026-01-20'));

        // -- Act & Assert
        self::assertSame($expectedResult, $dateRange->contains(Date::fromString($date)));
        self::assertSame(!$expectedResult, $dateRange->notContains(Date::fromString($date)));
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: string,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'before start' => [false, '2026-01-09'],
            'start' => [true, '2026-01-10'],
            'within' => [true, '2026-01-15'],
            'end' => [true, '2026-01-20'],
            'after end' => [false, '2026-01-21'],
        ];
    }

    #[Test]
    #[DataProvider('rangeDataProvider')]
    public function contains_range_works(
        bool $expectedResult,
        string $start,
        string $end,
    ): void {
        // -- Arrange
        $dateRange = new DateRange(Date::fromString('2026-01-10'), Date::fromString('2026-01-20'));
        $otherDateRange = new DateRange(Date::fromString($start), Date::fromString($end));

        // -- Act & Assert
        self::assertSame($expectedResult, $dateRange->containsRange($otherDateRange));
        self::assertSame(!$expectedResult, $dateRange->notContainsRange($otherDateRange));
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: string,
     *   2: string,
     * }>
     */
    public static function rangeDataProvider(): array
    {
        return [
            'same range' => [true, '2026-01-10', '2026-01-20'],
            'within' => [true, '2026-01-12', '2026-01-15'],
            'starts one day before' => [false, '2026-01-09', '2026-01-15'],
            'ends one day after' => [false, '2026-01-15', '2026-01-21'],
            'completely outside' => [false, '2026-02-01', '2026-02-10'],
        ];
    }

    #[Test]
    #[DataProvider('periodLimitDataProvider')]
    public function contains_with_period_limit_works(
        bool $expectedResult,
        PeriodLimit $periodLimit,
        string $date,
    ): void {
        // -- Arrange
        $dateRange = new DateRange(Date::fromString('2026-01-10'), Date::fromString('2026-01-20'));

        // -- Act & Assert
        self::assertSame($expectedResult, $dateRange->contains(Date::fromString($date), $periodLimit));
        self::assertSame(!$expectedResult, $dateRange->notContains(Date::fromString($date), $periodLimit));
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: PeriodLimit,
     *   2: string,
     * }>
     */
    public static function periodLimitDataProvider(): array
    {
        return [
            'start including start' => [true, PeriodLimit::INCLUDING_START, '2026-01-10'],
            'end including start' => [false, PeriodLimit::INCLUDING_START, '2026-01-20'],
            'start including end' => [false, PeriodLimit::INCLUDING_END, '2026-01-10'],
            'end including end' => [true, PeriodLimit::INCLUDING_END, '2026-01-20'],
            'start excluding start and end' => [false, PeriodLimit::EXCLUDING_START_AND_END, '2026-01-10'],
            'within excluding start and end' => [true, PeriodLimit::EXCLUDING_START_AND_END, '2026-01-15'],
            'end excluding start and end' => [false, PeriodLimit::EXCLUDING_START_AND_END, '2026-01-20'],
        ];
    }
}
