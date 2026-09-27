<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\CalendarPeriod;

use DigitalCraftsman\DateTimePrecision\CalendarPeriod;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(CalendarPeriod::class)]
final class IsEqualToTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function is_equal_to_works(
        bool $expectedResult,
        CalendarPeriod $calendarPeriod,
        CalendarPeriod $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $calendarPeriod->isEqualTo($comparator));
        self::assertSame(!$expectedResult, $calendarPeriod->isNotEqualTo($comparator));
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: CalendarPeriod,
     *   2: CalendarPeriod,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'same amount and unit' => [
                true,
                CalendarPeriod::days(7),
                CalendarPeriod::days(7),
            ],
            'different amount' => [
                false,
                CalendarPeriod::days(7),
                CalendarPeriod::days(8),
            ],
            'same amount but different unit' => [
                false,
                CalendarPeriod::days(1),
                CalendarPeriod::weeks(1),
            ],
            'same length but different unit' => [
                false,
                CalendarPeriod::days(7),
                CalendarPeriod::weeks(1),
            ],
        ];
    }
}
