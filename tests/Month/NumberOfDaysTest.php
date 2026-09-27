<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Month;

use DigitalCraftsman\DateTimePrecision\Month;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Month::class)]
final class NumberOfDaysTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function number_of_days_works(
        int $expectedResult,
        Month $month,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $month->numberOfDays());
    }

    /**
     * @return array<string, array{
     *   0: int,
     *   1: Month,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'january' => [31, Month::fromString('2026-01')],
            'april' => [30, Month::fromString('2026-04')],
            'february' => [28, Month::fromString('2026-02')],
            'february in leap year' => [29, Month::fromString('2024-02')],
        ];
    }
}
