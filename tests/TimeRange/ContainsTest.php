<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\TimeRange;

use DigitalCraftsman\DateTimePrecision\PeriodLimit;
use DigitalCraftsman\DateTimePrecision\Time;
use DigitalCraftsman\DateTimePrecision\TimeRange;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(TimeRange::class)]
final class ContainsTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function contains_works(
        bool $expectedResult,
        string $start,
        string $end,
        string $time,
    ): void {
        // -- Arrange
        $timeRange = new TimeRange(Time::fromString($start), Time::fromString($end));

        // -- Act & Assert
        self::assertSame($expectedResult, $timeRange->contains(Time::fromString($time)));
        self::assertSame(!$expectedResult, $timeRange->notContains(Time::fromString($time)));
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: string,
     *   2: string,
     *   3: string,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'before start' => [false, '10:00:00', '12:00:00', '09:59:59'],
            'start is included' => [true, '10:00:00', '12:00:00', '10:00:00'],
            'within' => [true, '10:00:00', '12:00:00', '11:00:00'],
            'end is excluded' => [false, '10:00:00', '12:00:00', '12:00:00'],
            'wrapping range before midnight' => [true, '21:00:00', '03:00:00', '23:00:00'],
            'wrapping range at midnight' => [true, '21:00:00', '03:00:00', '00:00:00'],
            'wrapping range after midnight' => [true, '21:00:00', '03:00:00', '02:59:59'],
            'wrapping range end is excluded' => [false, '21:00:00', '03:00:00', '03:00:00'],
            'wrapping range outside' => [false, '21:00:00', '03:00:00', '12:00:00'],
            'range ending at midnight shortly before' => [true, '21:00:00', '00:00:00', '23:59:59'],
            'range ending at midnight excludes midnight' => [false, '21:00:00', '00:00:00', '00:00:00'],
            'full day at midnight' => [true, '00:00:00', '00:00:00', '00:00:00'],
            'full day at end of day' => [true, '00:00:00', '00:00:00', '23:59:59'],
        ];
    }

    #[Test]
    #[DataProvider('rangeDataProvider')]
    public function contains_range_works(
        bool $expectedResult,
        string $start,
        string $end,
        string $otherStart,
        string $otherEnd,
    ): void {
        // -- Arrange
        $timeRange = new TimeRange(Time::fromString($start), Time::fromString($end));
        $otherTimeRange = new TimeRange(Time::fromString($otherStart), Time::fromString($otherEnd));

        // -- Act & Assert
        self::assertSame($expectedResult, $timeRange->containsRange($otherTimeRange));
        self::assertSame(!$expectedResult, $timeRange->notContainsRange($otherTimeRange));
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: string,
     *   2: string,
     *   3: string,
     *   4: string,
     * }>
     */
    public static function rangeDataProvider(): array
    {
        return [
            'same range' => [true, '10:00:00', '12:00:00', '10:00:00', '12:00:00'],
            'within' => [true, '10:00:00', '12:00:00', '10:30:00', '11:30:00'],
            'ending at end' => [true, '10:00:00', '12:00:00', '11:00:00', '12:00:00'],
            'ending after end' => [false, '10:00:00', '12:00:00', '11:00:00', '12:00:01'],
            'starting before start' => [false, '10:00:00', '12:00:00', '09:59:59', '11:00:00'],
            'wrapping range contains range after midnight' => [true, '21:00:00', '03:00:00', '01:00:00', '02:00:00'],
            'wrapping range contains range over midnight' => [true, '21:00:00', '03:00:00', '23:00:00', '01:00:00'],
            'range ending at midnight contains range ending at midnight' => [true, '18:00:00', '00:00:00', '20:00:00', '00:00:00'],
            'range not ending at midnight does not contain range ending at midnight' => [false, '18:00:00', '23:00:00', '20:00:00', '00:00:00'],
            'full day contains range ending at midnight' => [true, '00:00:00', '00:00:00', '20:00:00', '00:00:00'],
            'full day does not contain wrapping range' => [false, '00:00:00', '00:00:00', '23:00:00', '01:00:00'],
        ];
    }

    #[Test]
    #[DataProvider('overlapsDataProvider')]
    public function overlaps_works(
        bool $expectedResult,
        string $start,
        string $end,
        string $otherStart,
        string $otherEnd,
    ): void {
        // -- Arrange
        $timeRange = new TimeRange(Time::fromString($start), Time::fromString($end));
        $otherTimeRange = new TimeRange(Time::fromString($otherStart), Time::fromString($otherEnd));

        // -- Act & Assert
        self::assertSame($expectedResult, $timeRange->overlaps($otherTimeRange));
        self::assertSame($expectedResult, $otherTimeRange->overlaps($timeRange));
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: string,
     *   2: string,
     *   3: string,
     *   4: string,
     * }>
     */
    public static function overlapsDataProvider(): array
    {
        return [
            'ends at start' => [false, '10:00:00', '12:00:00', '08:00:00', '10:00:00'],
            'overlaps start' => [true, '10:00:00', '12:00:00', '09:00:00', '10:30:00'],
            'within' => [true, '10:00:00', '12:00:00', '10:30:00', '11:00:00'],
            'starts at end' => [false, '10:00:00', '12:00:00', '12:00:00', '13:00:00'],
            'wrapping ranges' => [true, '21:00:00', '03:00:00', '02:00:00', '04:00:00'],
            'wrapping range and range before' => [false, '21:00:00', '03:00:00', '12:00:00', '21:00:00'],
            'full day overlaps everything' => [true, '00:00:00', '00:00:00', '12:00:00', '13:00:00'],
        ];
    }

    #[Test]
    #[DataProvider('periodLimitDataProvider')]
    public function contains_with_period_limit_works(
        bool $expectedResult,
        PeriodLimit $periodLimit,
        string $start,
        string $end,
        string $time,
    ): void {
        // -- Arrange
        $timeRange = new TimeRange(Time::fromString($start), Time::fromString($end));

        // -- Act & Assert
        self::assertSame($expectedResult, $timeRange->contains(Time::fromString($time), $periodLimit));
        self::assertSame(!$expectedResult, $timeRange->notContains(Time::fromString($time), $periodLimit));
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: PeriodLimit,
     *   2: string,
     *   3: string,
     *   4: string,
     * }>
     */
    public static function periodLimitDataProvider(): array
    {
        return [
            'start including start and end' => [true, PeriodLimit::INCLUDING_START_AND_END, '10:00:00', '12:00:00', '10:00:00'],
            'end including start and end' => [true, PeriodLimit::INCLUDING_START_AND_END, '10:00:00', '12:00:00', '12:00:00'],
            'after end including start and end' => [false, PeriodLimit::INCLUDING_START_AND_END, '10:00:00', '12:00:00', '12:00:01'],
            'start including end' => [false, PeriodLimit::INCLUDING_END, '10:00:00', '12:00:00', '10:00:00'],
            'end including end' => [true, PeriodLimit::INCLUDING_END, '10:00:00', '12:00:00', '12:00:00'],
            'start excluding start and end' => [false, PeriodLimit::EXCLUDING_START_AND_END, '10:00:00', '12:00:00', '10:00:00'],
            'within excluding start and end' => [true, PeriodLimit::EXCLUDING_START_AND_END, '10:00:00', '12:00:00', '11:00:00'],
            'end excluding start and end' => [false, PeriodLimit::EXCLUDING_START_AND_END, '10:00:00', '12:00:00', '12:00:00'],
            'midnight as end including end' => [true, PeriodLimit::INCLUDING_START_AND_END, '21:00:00', '00:00:00', '00:00:00'],
            'end of wrapping range including end' => [true, PeriodLimit::INCLUDING_END, '21:00:00', '03:00:00', '03:00:00'],
            'midnight of full day including end' => [true, PeriodLimit::INCLUDING_END, '00:00:00', '00:00:00', '00:00:00'],
            'midnight of full day excluding start and end' => [false, PeriodLimit::EXCLUDING_START_AND_END, '00:00:00', '00:00:00', '00:00:00'],
            'noon of full day excluding start and end' => [true, PeriodLimit::EXCLUDING_START_AND_END, '00:00:00', '00:00:00', '12:00:00'],
        ];
    }
}
