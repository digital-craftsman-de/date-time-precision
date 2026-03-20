<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Weekday;

use DigitalCraftsman\DateTimePrecision\Weekday;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Weekday::class)]
final class IsAfterOrEqualToTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
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
     *   0: bool,
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
