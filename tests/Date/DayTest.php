<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Day;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Date */
final class DayTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProviderForDay
     *
     * @covers ::day
     */
    public function day_works(
        Day $expectedResult,
        Date $date,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $date->day());
    }

    /**
     * @return array<string, array{
     *   0: Day,
     *   1: Date,
     * }>
     */
    public static function dataProviderForDay(): array
    {
        return [
            'first day' => [
                new Day(1),
                Date::fromString('2022-10-01'),
            ],
            'middle of month' => [
                new Day(15),
                Date::fromString('2022-10-15'),
            ],
            'last day' => [
                new Day(31),
                Date::fromString('2022-10-31'),
            ],
        ];
    }
}
