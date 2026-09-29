<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\PeriodLimit;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Moment::class)]
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
        $start = Moment::fromString('2026-01-10 10:00:00');
        $end = Moment::fromString('2026-01-10 12:00:00');
        $subject = Moment::fromString($value);

        // -- Act & Assert
        self::assertSame($expectedResult, $subject->isBetween($start, $end, $periodLimit));
        self::assertSame(!$expectedResult, $subject->isNotBetween($start, $end, $periodLimit));
    }

    #[Test]
    public function is_between_includes_start_and_end_by_default(): void
    {
        // -- Act & Assert
        self::assertTrue(Moment::fromString('2026-01-10 10:00:00')->isBetween(Moment::fromString('2026-01-10 10:00:00'), Moment::fromString('2026-01-10 12:00:00')));
        self::assertTrue(Moment::fromString('2026-01-10 12:00:00')->isBetween(Moment::fromString('2026-01-10 10:00:00'), Moment::fromString('2026-01-10 12:00:00')));
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
            'before including start and end' => [false, PeriodLimit::INCLUDING_START_AND_END, '2026-01-10 09:59:59.999999'],
            'start including start and end' => [true, PeriodLimit::INCLUDING_START_AND_END, '2026-01-10 10:00:00'],
            'within including start and end' => [true, PeriodLimit::INCLUDING_START_AND_END, '2026-01-10 11:00:00'],
            'end including start and end' => [true, PeriodLimit::INCLUDING_START_AND_END, '2026-01-10 12:00:00'],
            'after including start and end' => [false, PeriodLimit::INCLUDING_START_AND_END, '2026-01-10 12:00:00.000001'],
            'before including start' => [false, PeriodLimit::INCLUDING_START, '2026-01-10 09:59:59.999999'],
            'start including start' => [true, PeriodLimit::INCLUDING_START, '2026-01-10 10:00:00'],
            'within including start' => [true, PeriodLimit::INCLUDING_START, '2026-01-10 11:00:00'],
            'end including start' => [false, PeriodLimit::INCLUDING_START, '2026-01-10 12:00:00'],
            'after including start' => [false, PeriodLimit::INCLUDING_START, '2026-01-10 12:00:00.000001'],
            'before including end' => [false, PeriodLimit::INCLUDING_END, '2026-01-10 09:59:59.999999'],
            'start including end' => [false, PeriodLimit::INCLUDING_END, '2026-01-10 10:00:00'],
            'within including end' => [true, PeriodLimit::INCLUDING_END, '2026-01-10 11:00:00'],
            'end including end' => [true, PeriodLimit::INCLUDING_END, '2026-01-10 12:00:00'],
            'after including end' => [false, PeriodLimit::INCLUDING_END, '2026-01-10 12:00:00.000001'],
            'before excluding start and end' => [false, PeriodLimit::EXCLUDING_START_AND_END, '2026-01-10 09:59:59.999999'],
            'start excluding start and end' => [false, PeriodLimit::EXCLUDING_START_AND_END, '2026-01-10 10:00:00'],
            'within excluding start and end' => [true, PeriodLimit::EXCLUDING_START_AND_END, '2026-01-10 11:00:00'],
            'end excluding start and end' => [false, PeriodLimit::EXCLUDING_START_AND_END, '2026-01-10 12:00:00'],
            'after excluding start and end' => [false, PeriodLimit::EXCLUDING_START_AND_END, '2026-01-10 12:00:00.000001'],
        ];
    }
}
