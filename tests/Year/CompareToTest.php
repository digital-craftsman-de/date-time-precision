<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Year;

use DigitalCraftsman\DateTimePrecision\Year;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Year */
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
        Year $year,
        Year $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $year->compareTo($comparator));
    }

    /**
     * @return array<string, array{
     *   0: int,
     *   1: Year,
     *   2: Year,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'previous year' => [
                1,
                Year::fromString('2022'),
                Year::fromString('2021'),
            ],
            'same year' => [
                0,
                Year::fromString('2022'),
                Year::fromString('2022'),
            ],
            'next year' => [
                -1,
                Year::fromString('2022'),
                Year::fromString('2023'),
            ],
        ];
    }
}
