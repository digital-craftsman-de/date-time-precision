<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Month;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\DateRange;
use DigitalCraftsman\DateTimePrecision\Month;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Month::class)]
final class ContainsTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function contains_works(
        bool $expectedResult,
        string $date,
    ): void {
        // -- Arrange
        $month = Month::fromString('2026-02');

        // -- Act & Assert
        self::assertSame($expectedResult, $month->contains(Date::fromString($date)));
        self::assertSame(!$expectedResult, $month->notContains(Date::fromString($date)));
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
            'last day of previous month' => [false, '2026-01-31'],
            'first day' => [true, '2026-02-01'],
            'last day' => [true, '2026-02-28'],
            'first day of next month' => [false, '2026-03-01'],
            'same month in other year' => [false, '2025-02-15'],
        ];
    }

    #[Test]
    public function date_range_works(): void
    {
        // -- Act & Assert
        self::assertEquals(
            new DateRange(Date::fromString('2024-02-01'), Date::fromString('2024-02-29')),
            Month::fromString('2024-02')->dateRange(),
        );
    }
}
