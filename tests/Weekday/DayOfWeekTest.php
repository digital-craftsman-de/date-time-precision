<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Weekday;

use DigitalCraftsman\DateTimePrecision\Weekday;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Weekday */
final class DayOfWeekTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::dayOfWeek
     */
    public function day_of_week_works(
        int $expectedResult,
        Weekday $weekday,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $weekday->dayOfWeek());
    }

    /**
     * @return array<string, array{
     *   0: int,
     *   1: Weekday,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'monday' => [
                1,
                Weekday::MONDAY,
            ],
            'tuesday' => [
                2,
                Weekday::TUESDAY,
            ],
            'wednesday' => [
                3,
                Weekday::WEDNESDAY,
            ],
            'thursday' => [
                4,
                Weekday::THURSDAY,
            ],
            'friday' => [
                5,
                Weekday::FRIDAY,
            ],
            'saturday' => [
                6,
                Weekday::SATURDAY,
            ],
            'sunday' => [
                7,
                Weekday::SUNDAY,
            ],
        ];
    }
}
