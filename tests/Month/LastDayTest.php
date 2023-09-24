<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\Month;

use DigitalCraftsman\DateTimeParts\Date;
use DigitalCraftsman\DateTimeParts\Month;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\Month */
final class LastDayTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::lastDay
     */
    public function last_day_works(
        Date $expectedResult,
        Month $month,
    ): void {
        // -- Act & Assert
        self::assertTrue($expectedResult->isEqualTo($month->lastDay()));
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
                Date::fromString('2022-01-31'),
                Month::fromString('2022-01'),
            ],
            'februar 2022' => [
                Date::fromString('2022-02-28'),
                Month::fromString('2022-02'),
            ],
            'december 2022' => [
                Date::fromString('2022-12-31'),
                Month::fromString('2022-12'),
            ],
        ];
    }
}
