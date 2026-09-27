<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\CalendarPeriod;

use DigitalCraftsman\DateTimePrecision\CalendarPeriod;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(CalendarPeriod::class)]
final class ModifierTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function modifier_works(
        string $expectedResult,
        CalendarPeriod $calendarPeriod,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $calendarPeriod->modifier());
    }

    /**
     * @return array<string, array{
     *   0: string,
     *   1: CalendarPeriod,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'days' => [
                '2 days',
                CalendarPeriod::days(2),
            ],
            'weeks' => [
                '2 weeks',
                CalendarPeriod::weeks(2),
            ],
            'months' => [
                '2 months',
                CalendarPeriod::months(2),
            ],
            'quarters are converted to months' => [
                '6 months',
                CalendarPeriod::quarters(2),
            ],
            'years' => [
                '2 years',
                CalendarPeriod::years(2),
            ],
        ];
    }
}
