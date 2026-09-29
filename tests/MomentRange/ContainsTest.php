<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\MomentRange;

use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\MomentRange;
use DigitalCraftsman\DateTimePrecision\PeriodLimit;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(MomentRange::class)]
final class ContainsTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function contains_works(
        bool $expectedResult,
        string $moment,
    ): void {
        // -- Arrange
        $momentRange = new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00'));

        // -- Act & Assert
        self::assertSame($expectedResult, $momentRange->contains(Moment::fromString($moment)));
        self::assertSame(!$expectedResult, $momentRange->notContains(Moment::fromString($moment)));
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
            'before start' => [false, '2026-01-01 09:59:59.999999'],
            'start is included' => [true, '2026-01-01 10:00:00'],
            'within' => [true, '2026-01-01 11:00:00'],
            'just before end' => [true, '2026-01-01 11:59:59.999999'],
            'end is excluded' => [false, '2026-01-01 12:00:00'],
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
        $momentRange = new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00'));
        $otherMomentRange = new MomentRange(Moment::fromString($start), Moment::fromString($end));

        // -- Act & Assert
        self::assertSame($expectedResult, $momentRange->containsRange($otherMomentRange));
        self::assertSame(!$expectedResult, $momentRange->notContainsRange($otherMomentRange));
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
            'same range' => [true, '2026-01-01 10:00:00', '2026-01-01 12:00:00'],
            'within' => [true, '2026-01-01 10:30:00', '2026-01-01 11:30:00'],
            'starts before' => [false, '2026-01-01 09:59:59', '2026-01-01 11:00:00'],
            'ends after' => [false, '2026-01-01 11:00:00', '2026-01-01 12:00:01'],
        ];
    }

    #[Test]
    #[DataProvider('periodLimitDataProvider')]
    public function contains_with_period_limit_works(
        bool $expectedResult,
        PeriodLimit $periodLimit,
        string $moment,
    ): void {
        // -- Arrange
        $momentRange = new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00'));

        // -- Act & Assert
        self::assertSame($expectedResult, $momentRange->contains(Moment::fromString($moment), $periodLimit));
        self::assertSame(!$expectedResult, $momentRange->notContains(Moment::fromString($moment), $periodLimit));
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
            'start including start and end' => [true, PeriodLimit::INCLUDING_START_AND_END, '2026-01-01 10:00:00'],
            'end including start and end' => [true, PeriodLimit::INCLUDING_START_AND_END, '2026-01-01 12:00:00'],
            'start including end' => [false, PeriodLimit::INCLUDING_END, '2026-01-01 10:00:00'],
            'end including end' => [true, PeriodLimit::INCLUDING_END, '2026-01-01 12:00:00'],
            'start excluding start and end' => [false, PeriodLimit::EXCLUDING_START_AND_END, '2026-01-01 10:00:00'],
            'within excluding start and end' => [true, PeriodLimit::EXCLUDING_START_AND_END, '2026-01-01 11:00:00'],
        ];
    }
}
