<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Recurrence;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Dates;
use DigitalCraftsman\DateTimePrecision\Day;
use DigitalCraftsman\DateTimePrecision\Days;
use DigitalCraftsman\DateTimePrecision\PeriodLimit;
use DigitalCraftsman\DateTimePrecision\Recurrence;
use DigitalCraftsman\DateTimePrecision\Weekday;
use DigitalCraftsman\DateTimePrecision\Weekdays;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Recurrence::class)]
final class OccurrenceTest extends TestCase
{
    private static function recurrence(string $type): Recurrence
    {
        return match ($type) {
            'daily' => Recurrence::daily(),
            'monday and wednesday' => Recurrence::weekly(new Weekdays([Weekday::MONDAY, Weekday::WEDNESDAY])),
            'first and 31st' => Recurrence::monthly(new Days([new Day(1), new Day(31)])),
            '31st' => Recurrence::monthly(new Days([new Day(31)])),
        };
    }

    #[Test]
    #[DataProvider('occursOnDataProvider')]
    public function occurs_on_works(
        bool $expectedResult,
        string $recurrence,
        string $date,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, self::recurrence($recurrence)->occursOn(Date::fromString($date)));
        self::assertSame(!$expectedResult, self::recurrence($recurrence)->doesNotOccurOn(Date::fromString($date)));
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: string,
     *   2: string,
     * }>
     */
    public static function occursOnDataProvider(): array
    {
        return [
            'daily' => [true, 'daily', '2026-03-03'],
            'weekly on monday' => [true, 'monday and wednesday', '2026-03-02'],
            'weekly on tuesday' => [false, 'monday and wednesday', '2026-03-03'],
            'monthly on first' => [true, 'first and 31st', '2026-03-01'],
            'monthly on 31st' => [true, 'first and 31st', '2026-03-31'],
            'monthly on other day' => [false, 'first and 31st', '2026-03-15'],
            'monthly on last day of short month' => [false, '31st', '2026-04-30'],
        ];
    }

    #[Test]
    #[DataProvider('nextDataProvider')]
    public function next_occurrence_after_works(
        string $expectedResult,
        string $recurrence,
        string $date,
    ): void {
        // -- Act & Assert
        self::assertEquals(Date::fromString($expectedResult), self::recurrence($recurrence)->nextOccurrenceAfter(Date::fromString($date)));
    }

    /**
     * @return array<string, array{
     *   0: string,
     *   1: string,
     *   2: string,
     * }>
     */
    public static function nextDataProvider(): array
    {
        return [
            'daily' => ['2026-03-04', 'daily', '2026-03-03'],
            'weekly excludes given date' => ['2026-03-04', 'monday and wednesday', '2026-03-02'],
            'weekly into next week' => ['2026-03-09', 'monday and wednesday', '2026-03-04'],
            'monthly skips short months' => ['2026-03-31', '31st', '2026-01-31'],
        ];
    }

    #[Test]
    #[DataProvider('previousDataProvider')]
    public function previous_occurrence_on_or_before_works(
        string $expectedResult,
        string $recurrence,
        string $date,
    ): void {
        // -- Act & Assert
        self::assertEquals(Date::fromString($expectedResult), self::recurrence($recurrence)->previousOccurrenceOnOrBefore(Date::fromString($date)));
    }

    /**
     * @return array<string, array{
     *   0: string,
     *   1: string,
     *   2: string,
     * }>
     */
    public static function previousDataProvider(): array
    {
        return [
            'daily includes given date' => ['2026-03-03', 'daily', '2026-03-03'],
            'weekly includes given date' => ['2026-03-04', 'monday and wednesday', '2026-03-04'],
            'weekly into previous week' => ['2026-02-25', 'monday and wednesday', '2026-03-01'],
            'monthly skips short months' => ['2026-01-31', '31st', '2026-03-30'],
        ];
    }

    #[Test]
    public function occurrences_between_works(): void
    {
        // -- Arrange
        $recurrence = self::recurrence('monday and wednesday');
        $start = Date::fromString('2026-03-02');
        $end = Date::fromString('2026-03-11');

        // -- Act & Assert
        self::assertEquals(new Dates([
            Date::fromString('2026-03-02'),
            Date::fromString('2026-03-04'),
            Date::fromString('2026-03-09'),
            Date::fromString('2026-03-11'),
        ]), $recurrence->occurrencesBetween($start, $end));
        self::assertEquals(new Dates([
            Date::fromString('2026-03-04'),
            Date::fromString('2026-03-09'),
        ]), $recurrence->occurrencesBetween($start, $end, PeriodLimit::EXCLUDING_START_AND_END));
    }
}
