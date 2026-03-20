<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Days;

use DigitalCraftsman\DateTimePrecision\Day;
use DigitalCraftsman\DateTimePrecision\Days;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Days::class)]
final class ContainsTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     */
    public function contain_works(
        bool $expectedResult,
        Days $days,
        Day $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $days->contains($comparator));
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
            'day is contained' => [
                true,
                new Days([
                    new Day(1),
                    new Day(15),
                ]),
                new Day(1),
            ],
            'day is not contained' => [
                false,
                new Days([
                    new Day(1),
                    new Day(15),
                ]),
                new Day(20),
            ],
        ];
    }
}
