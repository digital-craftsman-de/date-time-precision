<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\CalendarPeriod;

use DigitalCraftsman\DateTimePrecision\CalendarPeriod;
use DigitalCraftsman\DateTimePrecision\Exception\InvalidCalendarPeriod;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(CalendarPeriod::class)]
#[CoversClass(InvalidCalendarPeriod::class)]
final class MultiplyTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function multiply_works(
        CalendarPeriod $expectedResult,
        CalendarPeriod $calendarPeriod,
        int $factor,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $calendarPeriod->multiply($factor));
    }

    /**
     * @return array<string, array{
     *   0: CalendarPeriod,
     *   1: CalendarPeriod,
     *   2: int,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'multiply months' => [
                CalendarPeriod::months(6),
                CalendarPeriod::months(2),
                3,
            ],
            'multiply by zero' => [
                CalendarPeriod::weeks(0),
                CalendarPeriod::weeks(2),
                0,
            ],
        ];
    }

    #[Test]
    public function multiply_fails_with_negative_factor(): void
    {
        // -- Assert
        $this->expectException(InvalidCalendarPeriod::class);

        // -- Act
        CalendarPeriod::months(2)->multiply(-1);
    }
}
