<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\DateRange;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\DateRange;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(DateRange::class)]
final class OverlapsTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function overlaps_works(
        bool $expectedResult,
        string $start,
        string $end,
    ): void {
        // -- Arrange
        $dateRange = new DateRange(Date::fromString('2026-01-10'), Date::fromString('2026-01-20'));
        $otherDateRange = new DateRange(Date::fromString($start), Date::fromString($end));

        // -- Act & Assert
        self::assertSame($expectedResult, $dateRange->overlaps($otherDateRange));
        self::assertSame($expectedResult, $otherDateRange->overlaps($dateRange));
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: string,
     *   2: string,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'ends the day before' => [false, '2026-01-01', '2026-01-09'],
            'ends on the start date' => [true, '2026-01-01', '2026-01-10'],
            'within' => [true, '2026-01-12', '2026-01-15'],
            'starts on the end date' => [true, '2026-01-20', '2026-01-25'],
            'starts the day after' => [false, '2026-01-21', '2026-01-25'],
            'surrounds' => [true, '2026-01-01', '2026-01-31'],
        ];
    }
}
