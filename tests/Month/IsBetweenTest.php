<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Month;

use DigitalCraftsman\DateTimePrecision\Month;
use DigitalCraftsman\DateTimePrecision\PeriodLimit;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Month::class)]
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
        $start = Month::fromString('2026-03');
        $end = Month::fromString('2026-06');
        $subject = Month::fromString($value);

        // -- Act & Assert
        self::assertSame($expectedResult, $subject->isBetween($start, $end, $periodLimit));
        self::assertSame(!$expectedResult, $subject->isNotBetween($start, $end, $periodLimit));
    }

    #[Test]
    public function is_between_includes_start_and_end_by_default(): void
    {
        // -- Act & Assert
        self::assertTrue(Month::fromString('2026-03')->isBetween(Month::fromString('2026-03'), Month::fromString('2026-06')));
        self::assertTrue(Month::fromString('2026-06')->isBetween(Month::fromString('2026-03'), Month::fromString('2026-06')));
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
            'before including start and end' => [false, PeriodLimit::INCLUDING_START_AND_END, '2026-02'],
            'start including start and end' => [true, PeriodLimit::INCLUDING_START_AND_END, '2026-03'],
            'within including start and end' => [true, PeriodLimit::INCLUDING_START_AND_END, '2026-04'],
            'end including start and end' => [true, PeriodLimit::INCLUDING_START_AND_END, '2026-06'],
            'after including start and end' => [false, PeriodLimit::INCLUDING_START_AND_END, '2026-07'],
            'before including start' => [false, PeriodLimit::INCLUDING_START, '2026-02'],
            'start including start' => [true, PeriodLimit::INCLUDING_START, '2026-03'],
            'within including start' => [true, PeriodLimit::INCLUDING_START, '2026-04'],
            'end including start' => [false, PeriodLimit::INCLUDING_START, '2026-06'],
            'after including start' => [false, PeriodLimit::INCLUDING_START, '2026-07'],
            'before including end' => [false, PeriodLimit::INCLUDING_END, '2026-02'],
            'start including end' => [false, PeriodLimit::INCLUDING_END, '2026-03'],
            'within including end' => [true, PeriodLimit::INCLUDING_END, '2026-04'],
            'end including end' => [true, PeriodLimit::INCLUDING_END, '2026-06'],
            'after including end' => [false, PeriodLimit::INCLUDING_END, '2026-07'],
            'before excluding start and end' => [false, PeriodLimit::EXCLUDING_START_AND_END, '2026-02'],
            'start excluding start and end' => [false, PeriodLimit::EXCLUDING_START_AND_END, '2026-03'],
            'within excluding start and end' => [true, PeriodLimit::EXCLUDING_START_AND_END, '2026-04'],
            'end excluding start and end' => [false, PeriodLimit::EXCLUDING_START_AND_END, '2026-06'],
            'after excluding start and end' => [false, PeriodLimit::EXCLUDING_START_AND_END, '2026-07'],
        ];
    }
}
