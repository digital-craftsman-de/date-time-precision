<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Year;

use DigitalCraftsman\DateTimePrecision\Year;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Year */
final class IsNotAfterTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::isNotAfter
     */
    public function is_not_after_works(
        bool $expectedResult,
        Year $year,
        Year $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $year->isNotAfter($comparator));
    }

    /**
     * @return array<string, array{
     *   0: boolean,
     *   1: Year,
     *   2: Year,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'previous year' => [
                true,
                Year::fromString('2021'),
                Year::fromString('2022'),
            ],
            'same date' => [
                true,
                Year::fromString('2022'),
                Year::fromString('2022'),
            ],
            'next year' => [
                false,
                Year::fromString('2023'),
                Year::fromString('2022'),
            ],
        ];
    }
}
