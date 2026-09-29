<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Week;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Date::class)]
final class WeekTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function week_works(
        string $expectedWeek,
        string $expectedStartOfWeek,
        string $expectedEndOfWeek,
        string $date,
    ): void {
        // -- Arrange
        $subject = Date::fromString($date);

        // -- Act & Assert
        self::assertEquals(Week::fromString($expectedWeek), $subject->week());
        self::assertEquals(Date::fromString($expectedStartOfWeek), $subject->startOfWeek());
        self::assertEquals(Date::fromString($expectedEndOfWeek), $subject->endOfWeek());
    }

    /**
     * @return array<string, array{
     *   0: string,
     *   1: string,
     *   2: string,
     *   3: string,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'monday' => ['2026-W10', '2026-03-02', '2026-03-08', '2026-03-02'],
            'wednesday' => ['2026-W10', '2026-03-02', '2026-03-08', '2026-03-04'],
            'sunday' => ['2026-W10', '2026-03-02', '2026-03-08', '2026-03-08'],
            'new year in week of previous year' => ['2026-W53', '2026-12-28', '2027-01-03', '2027-01-01'],
            'end of year in week of next year' => ['2026-W01', '2025-12-29', '2026-01-04', '2025-12-31'],
        ];
    }
}
