<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\PeriodLimit;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Date::class)]
final class IsBetweenTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function is_between_works(
        bool $expectedResult,
        PeriodLimit $periodLimit,
        string $value,
    ): void {
        // -- Arrange
        $start = Date::fromString('2026-01-10');
        $end = Date::fromString('2026-01-20');
        $subject = Date::fromString($value);

        // -- Act & Assert
        self::assertSame($expectedResult, $subject->isBetween($start, $end, $periodLimit));
        self::assertSame(!$expectedResult, $subject->isNotBetween($start, $end, $periodLimit));
    }

    #[Test]
    public function is_between_includes_start_and_end_by_default(): void
    {
        // -- Act & Assert
        self::assertTrue(Date::fromString('2026-01-10')->isBetween(Date::fromString('2026-01-10'), Date::fromString('2026-01-20')));
        self::assertTrue(Date::fromString('2026-01-20')->isBetween(Date::fromString('2026-01-10'), Date::fromString('2026-01-20')));
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: PeriodLimit,
     *   2: string,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'before including start and end' => [false, PeriodLimit::INCLUDING_START_AND_END, '2026-01-09'],
            'start including start and end' => [true, PeriodLimit::INCLUDING_START_AND_END, '2026-01-10'],
            'within including start and end' => [true, PeriodLimit::INCLUDING_START_AND_END, '2026-01-15'],
            'end including start and end' => [true, PeriodLimit::INCLUDING_START_AND_END, '2026-01-20'],
            'after including start and end' => [false, PeriodLimit::INCLUDING_START_AND_END, '2026-01-21'],
            'before including start' => [false, PeriodLimit::INCLUDING_START, '2026-01-09'],
            'start including start' => [true, PeriodLimit::INCLUDING_START, '2026-01-10'],
            'within including start' => [true, PeriodLimit::INCLUDING_START, '2026-01-15'],
            'end including start' => [false, PeriodLimit::INCLUDING_START, '2026-01-20'],
            'after including start' => [false, PeriodLimit::INCLUDING_START, '2026-01-21'],
            'before including end' => [false, PeriodLimit::INCLUDING_END, '2026-01-09'],
            'start including end' => [false, PeriodLimit::INCLUDING_END, '2026-01-10'],
            'within including end' => [true, PeriodLimit::INCLUDING_END, '2026-01-15'],
            'end including end' => [true, PeriodLimit::INCLUDING_END, '2026-01-20'],
            'after including end' => [false, PeriodLimit::INCLUDING_END, '2026-01-21'],
            'before excluding start and end' => [false, PeriodLimit::EXCLUDING_START_AND_END, '2026-01-09'],
            'start excluding start and end' => [false, PeriodLimit::EXCLUDING_START_AND_END, '2026-01-10'],
            'within excluding start and end' => [true, PeriodLimit::EXCLUDING_START_AND_END, '2026-01-15'],
            'end excluding start and end' => [false, PeriodLimit::EXCLUDING_START_AND_END, '2026-01-20'],
            'after excluding start and end' => [false, PeriodLimit::EXCLUDING_START_AND_END, '2026-01-21'],
        ];
    }
}
