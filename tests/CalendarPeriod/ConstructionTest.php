<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\CalendarPeriod;

use DigitalCraftsman\DateTimePrecision\CalendarPeriod;
use DigitalCraftsman\DateTimePrecision\CalendarUnit;
use DigitalCraftsman\DateTimePrecision\Exception\InvalidCalendarPeriod;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(CalendarPeriod::class)]
#[CoversClass(InvalidCalendarPeriod::class)]
final class ConstructionTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function construction_works(
        int $expectedAmount,
        CalendarUnit $expectedUnit,
        CalendarPeriod $calendarPeriod,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedAmount, $calendarPeriod->amount);
        self::assertSame($expectedUnit, $calendarPeriod->unit);
    }

    /**
     * @return array<string, array{
     *   0: int,
     *   1: CalendarUnit,
     *   2: CalendarPeriod,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'zero through constructor' => [
                0,
                CalendarUnit::DAY,
                new CalendarPeriod(0, CalendarUnit::DAY),
            ],
            'days' => [
                3,
                CalendarUnit::DAY,
                CalendarPeriod::days(3),
            ],
            'weeks' => [
                3,
                CalendarUnit::WEEK,
                CalendarPeriod::weeks(3),
            ],
            'months' => [
                3,
                CalendarUnit::MONTH,
                CalendarPeriod::months(3),
            ],
            'quarters' => [
                3,
                CalendarUnit::QUARTER,
                CalendarPeriod::quarters(3),
            ],
            'years' => [
                3,
                CalendarUnit::YEAR,
                CalendarPeriod::years(3),
            ],
        ];
    }

    #[Test]
    public function construction_fails_with_negative_amount(): void
    {
        // -- Assert
        $this->expectException(InvalidCalendarPeriod::class);

        // -- Act
        CalendarPeriod::days(-1);
    }
}
