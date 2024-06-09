<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Weekdays;

use DigitalCraftsman\DateTimePrecision\Weekday;
use DigitalCraftsman\DateTimePrecision\Weekdays;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Weekdays */
final class ContainsTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::contains
     */
    public function contain_works(
        bool $expectedResult,
        Weekdays $weekdays,
        Weekday $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $weekdays->contains($comparator));
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: Weekdays,
     *   2: Weekday,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'tuesday' => [
                true,
                new Weekdays([
                    Weekday::TUESDAY,
                    Weekday::WEDNESDAY,
                ]),
                Weekday::TUESDAY,
            ],
            'thursday' => [
                false,
                new Weekdays([
                    Weekday::MONDAY,
                    Weekday::WEDNESDAY,
                ]),
                Weekday::THURSDAY,
            ],
        ];
    }
}
