<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Weekday;

use DigitalCraftsman\DateTimePrecision\Weekday;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Weekday */
final class IsAfterOrEqualToTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::isAfterOrEqualTo
     */
    public function is_after_or_equal_to_works(
        bool $expectedResult,
        Weekday $weekday,
        Weekday $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $weekday->isAfterOrEqualTo($comparator));
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
                false,
                Weekday::MONDAY,
                Weekday::TUESDAY,
            ],
            'same day' => [
                true,
                Weekday::TUESDAY,
                Weekday::TUESDAY,
            ],
            '1 day later' => [
                true,
                Weekday::TUESDAY,
                Weekday::MONDAY,
            ],
        ];
    }
}
