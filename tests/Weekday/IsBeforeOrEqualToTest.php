<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Weekday;

use DigitalCraftsman\DateTimePrecision\Weekday;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Weekday */
final class IsBeforeOrEqualToTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::isBeforeOrEqualTo
     */
    public function is_before_or_equal_to_works(
        bool $expectedResult,
        Weekday $weekday,
        Weekday $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $weekday->isBeforeOrEqualTo($comparator));
    }

    /**
     * @return array<string, array{
     *   0: boolean,
     *   1: Weekday,
     *   2: Weekday,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            '1 day before' => [
                true,
                Weekday::MONDAY,
                Weekday::TUESDAY,
            ],
            'same day' => [
                true,
                Weekday::TUESDAY,
                Weekday::TUESDAY,
            ],
            '1 day later' => [
                false,
                Weekday::TUESDAY,
                Weekday::MONDAY,
            ],
        ];
    }
}
