<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Days;

use DigitalCraftsman\DateTimePrecision\Day;
use DigitalCraftsman\DateTimePrecision\Days;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Days::class)]
final class NotContainsTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function not_contain_works(
        bool $expectedResult,
        Days $days,
        Day $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $days->notContains($comparator));
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: Days,
     *   2: Day,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'day is not contained' => [
                true,
                new Days([
                    new Day(1),
                    new Day(15),
                ]),
                new Day(20),
            ],
            'day is contained' => [
                false,
                new Days([
                    new Day(1),
                    new Day(15),
                ]),
                new Day(15),
            ],
        ];
    }
}
