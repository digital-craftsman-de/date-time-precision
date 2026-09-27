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
final class IsEqualToTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function is_equal_to_works(
        bool $expectedResult,
        string $start,
        string $end,
    ): void {
        // -- Arrange
        $dateRange = new DateRange(Date::fromString('2026-01-10'), Date::fromString('2026-01-20'));
        $otherDateRange = new DateRange(Date::fromString($start), Date::fromString($end));

        // -- Act & Assert
        self::assertSame($expectedResult, $dateRange->isEqualTo($otherDateRange));
        self::assertSame(!$expectedResult, $dateRange->isNotEqualTo($otherDateRange));
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
            'same' => [true, '2026-01-10', '2026-01-20'],
            'different start' => [false, '2026-01-11', '2026-01-20'],
            'different end' => [false, '2026-01-10', '2026-01-21'],
        ];
    }
}
