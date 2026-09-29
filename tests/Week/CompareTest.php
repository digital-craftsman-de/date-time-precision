<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Week;

use DigitalCraftsman\DateTimePrecision\PeriodLimit;
use DigitalCraftsman\DateTimePrecision\Week;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Week::class)]
final class CompareTest extends TestCase
{
    /**
     * @param array{
     *   isEqualTo: bool,
     *   isBefore: bool,
     *   isBeforeOrEqualTo: bool,
     *   isAfter: bool,
     *   isAfterOrEqualTo: bool,
     *   compareTo: int,
     * } $expectedResult
     */
    #[Test]
    #[DataProvider('dataProvider')]
    public function comparison_works(
        array $expectedResult,
        string $week,
        string $comparator,
    ): void {
        // -- Arrange
        $subject = Week::fromString($week);
        $other = Week::fromString($comparator);

        // -- Act & Assert
        self::assertSame($expectedResult['isEqualTo'], $subject->isEqualTo($other));
        self::assertSame(!$expectedResult['isEqualTo'], $subject->isNotEqualTo($other));
        self::assertSame($expectedResult['isBefore'], $subject->isBefore($other));
        self::assertSame(!$expectedResult['isBefore'], $subject->isNotBefore($other));
        self::assertSame($expectedResult['isBeforeOrEqualTo'], $subject->isBeforeOrEqualTo($other));
        self::assertSame(!$expectedResult['isBeforeOrEqualTo'], $subject->isNotBeforeOrEqualTo($other));
        self::assertSame($expectedResult['isAfter'], $subject->isAfter($other));
        self::assertSame(!$expectedResult['isAfter'], $subject->isNotAfter($other));
        self::assertSame($expectedResult['isAfterOrEqualTo'], $subject->isAfterOrEqualTo($other));
        self::assertSame(!$expectedResult['isAfterOrEqualTo'], $subject->isNotAfterOrEqualTo($other));
        self::assertSame($expectedResult['compareTo'], $subject->compareTo($other));
        self::assertSame($expectedResult['compareTo'], Week::compare($subject, $other));
    }

    /**
     * @return array<string, array{
     *   0: array{
     *     isEqualTo: bool,
     *     isBefore: bool,
     *     isBeforeOrEqualTo: bool,
     *     isAfter: bool,
     *     isAfterOrEqualTo: bool,
     *     compareTo: int,
     *   },
     *   1: string,
     *   2: string,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'before across year' => [
                ['isEqualTo' => false, 'isBefore' => true, 'isBeforeOrEqualTo' => true, 'isAfter' => false, 'isAfterOrEqualTo' => false, 'compareTo' => -1],
                '2025-W52',
                '2026-W01',
            ],
            'equal' => [
                ['isEqualTo' => true, 'isBefore' => false, 'isBeforeOrEqualTo' => true, 'isAfter' => false, 'isAfterOrEqualTo' => true, 'compareTo' => 0],
                '2026-W10',
                '2026-W10',
            ],
            'after' => [
                ['isEqualTo' => false, 'isBefore' => false, 'isBeforeOrEqualTo' => false, 'isAfter' => true, 'isAfterOrEqualTo' => true, 'compareTo' => 1],
                '2026-W11',
                '2026-W10',
            ],
        ];
    }

    #[Test]
    #[DataProvider('betweenDataProvider')]
    public function is_between_works(
        bool $expectedResult,
        PeriodLimit $periodLimit,
        string $week,
    ): void {
        // -- Arrange
        $start = Week::fromString('2026-W10');
        $end = Week::fromString('2026-W12');

        // -- Act & Assert
        self::assertSame($expectedResult, Week::fromString($week)->isBetween($start, $end, $periodLimit));
        self::assertSame(!$expectedResult, Week::fromString($week)->isNotBetween($start, $end, $periodLimit));
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: PeriodLimit,
     *   2: string,
     * }>
     */
    public static function betweenDataProvider(): array
    {
        return [
            'before' => [false, PeriodLimit::INCLUDING_START_AND_END, '2026-W09'],
            'start included' => [true, PeriodLimit::INCLUDING_START_AND_END, '2026-W10'],
            'within' => [true, PeriodLimit::EXCLUDING_START_AND_END, '2026-W11'],
            'end included' => [true, PeriodLimit::INCLUDING_START_AND_END, '2026-W12'],
            'start excluded' => [false, PeriodLimit::INCLUDING_END, '2026-W10'],
            'end excluded' => [false, PeriodLimit::INCLUDING_START, '2026-W12'],
            'after' => [false, PeriodLimit::INCLUDING_START_AND_END, '2026-W13'],
        ];
    }

    #[Test]
    public function min_and_max_works(): void
    {
        // -- Act & Assert
        self::assertEquals(Week::fromString('2025-W52'), Week::min(Week::fromString('2026-W01'), Week::fromString('2025-W52'), Week::fromString('2026-W02')));
        self::assertEquals(Week::fromString('2026-W02'), Week::max(Week::fromString('2026-W01'), Week::fromString('2026-W02'), Week::fromString('2025-W52')));
        self::assertEquals(Week::fromString('2026-W01'), Week::min(Week::fromString('2026-W01')));
        self::assertEquals(Week::fromString('2026-W01'), Week::max(Week::fromString('2026-W01')));
    }
}
