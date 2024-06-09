<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Weekday;

use DigitalCraftsman\DateTimePrecision\Weekday;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Weekday */
final class CompareToTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::compareTo
     */
    public function compare_to_works(
        int $expectedResult,
        Weekday $weekday,
        Weekday $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $weekday->compareTo($comparator));
    }

    /**
     * @return array<string, array{
     *   0: int,
     *   1: Weekday,
     *   2: Weekday,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            '1 weekday later' => [
                1,
                Weekday::THURSDAY,
                Weekday::WEDNESDAY,
            ],
            'same weekday' => [
                0,
                Weekday::SATURDAY,
                Weekday::SATURDAY,
            ],
            '1 weekday before' => [
                -1,
                Weekday::TUESDAY,
                Weekday::WEDNESDAY,
            ],
            '2 weekdays before' => [
                -1,
                Weekday::MONDAY,
                Weekday::WEDNESDAY,
            ],
        ];
    }
}
