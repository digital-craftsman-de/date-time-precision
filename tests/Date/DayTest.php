<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Day;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Date::class)]
final class DayTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProviderForDay')]
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
