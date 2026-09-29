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
    public function construction_works(): void
    {
        // -- Act
        $calendarPeriod = new CalendarPeriod(0, CalendarUnit::DAY);

        // -- Assert
        self::assertSame(0, $calendarPeriod->amount);
        self::assertSame(CalendarUnit::DAY, $calendarPeriod->unit);
    }

    /**
     * The factory methods are called in the test instead of the data provider, as data providers aren't part of the code coverage.
     *
     * @param \Closure(int): CalendarPeriod $factory
     */
    #[Test]
    #[DataProvider('dataProvider')]
    public function construction_through_factory_works(
        CalendarUnit $expectedUnit,
        \Closure $factory,
    ): void {
        // -- Act
        $calendarPeriod = $factory(3);

        // -- Assert
        self::assertSame(3, $calendarPeriod->amount);
        self::assertSame($expectedUnit, $calendarPeriod->unit);
    }

    /**
     * @return array<string, array{
     *   0: CalendarUnit,
     *   1: \Closure(int): CalendarPeriod,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'days' => [
                CalendarUnit::DAY,
                CalendarPeriod::days(...),
            ],
            'weeks' => [
                CalendarUnit::WEEK,
                CalendarPeriod::weeks(...),
            ],
            'months' => [
                CalendarUnit::MONTH,
                CalendarPeriod::months(...),
            ],
            'quarters' => [
                CalendarUnit::QUARTER,
                CalendarPeriod::quarters(...),
            ],
            'years' => [
                CalendarUnit::YEAR,
                CalendarPeriod::years(...),
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
