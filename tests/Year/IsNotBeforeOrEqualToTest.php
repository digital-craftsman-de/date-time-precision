<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Year;

use DigitalCraftsman\DateTimePrecision\Year;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Year */
final class IsNotBeforeOrEqualToTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::isNotBeforeOrEqualTo
     */
    public function is_not_before_or_equal_to_works(
        bool $expectedResult,
        Year $year,
        Year $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $year->isNotBeforeOrEqualTo($comparator));
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: Year,
     *   2: Year,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'previous year' => [
                false,
                Year::fromString('2021'),
                Year::fromString('2022'),
            ],
            'same date' => [
                false,
                Year::fromString('2022'),
                Year::fromString('2022'),
            ],
            'next year' => [
                true,
                Year::fromString('2023'),
                Year::fromString('2022'),
            ],
        ];
    }
}
