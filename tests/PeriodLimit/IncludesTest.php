<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\PeriodLimit;

use DigitalCraftsman\DateTimePrecision\PeriodLimit;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(PeriodLimit::class)]
final class IncludesTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function includes_works(
        bool $expectedIncludesStart,
        bool $expectedIncludesEnd,
        PeriodLimit $periodLimit,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedIncludesStart, $periodLimit->includesStart());
        self::assertSame($expectedIncludesEnd, $periodLimit->includesEnd());
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: bool,
     *   2: PeriodLimit,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'including start and end' => [true, true, PeriodLimit::INCLUDING_START_AND_END],
            'including start' => [true, false, PeriodLimit::INCLUDING_START],
            'including end' => [false, true, PeriodLimit::INCLUDING_END],
            'excluding start and end' => [false, false, PeriodLimit::EXCLUDING_START_AND_END],
        ];
    }
}
