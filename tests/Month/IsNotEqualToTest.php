<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Month;

use DigitalCraftsman\DateTimePrecision\Month;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Month::class)]
final class IsNotEqualToTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function is_not_equal_to_works(
        bool $expectedResult,
        Month $month,
        Month $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $month->isNotEqualTo($comparator));
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: Month,
     *   2: Month,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'previous year' => [
                true,
                Month::fromString('2023-10'),
                Month::fromString('2022-10'),
            ],
            'same month' => [
                false,
                Month::fromString('2022-10'),
                Month::fromString('2022-10'),
            ],
            'next year' => [
                true,
                Month::fromString('2022-10'),
                Month::fromString('2023-10'),
            ],
            'next month' => [
                true,
                Month::fromString('2022-10'),
                Month::fromString('2022-11'),
            ],
        ];
    }
}
