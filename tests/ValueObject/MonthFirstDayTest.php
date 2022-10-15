<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\ValueObject;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\ValueObject\Month */
final class MonthFirstDayTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::firstDay
     */
    public function first_day_works(
        Date $expectedResult,
        Month $month,
    ): void {
        // -- Act & Assert
        self::assertTrue($expectedResult->isEqualTo($month->firstDay()));
    }

    /**
     * @return array<string, array{
     *   0: Date,
     *   1: Month,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'januar 2022' => [
                Date::fromString('2022-01-01'),
                Month::fromString('2022-01'),
            ],
            'december 2022' => [
                Date::fromString('2022-12-01'),
                Month::fromString('2022-12'),
            ],
        ];
    }
}
