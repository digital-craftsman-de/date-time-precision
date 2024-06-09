<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Weekday;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Date */
final class WeekdayTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProviderForWeekday
     *
     * @covers ::weekday
     */
    public function date_works(
        Weekday $expectedResult,
        Date $date,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $date->weekday());
    }

    /**
     * @return array<string, array{
     *   0: Weekday,
     *   1: Date,
     * }>
     */
    public static function dataProviderForWeekday(): array
    {
        return [
            'saturday' => [
                Weekday::SATURDAY,
                Date::fromString('2022-10-08'),
            ],
            'monday' => [
                Weekday::MONDAY,
                Date::fromString('2022-10-10'),
            ],
        ];
    }
}
