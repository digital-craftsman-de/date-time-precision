<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\Year;

use DigitalCraftsman\DateTimeParts\Year;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\Year */
final class YearIsBeforeOrEqualToTest extends TestCase
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
        Year $year,
        Year $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $year->isBeforeOrEqualTo($comparator));
    }

    /**
     * @return array<string, array{
     *   0: boolean,
     *   1: Year,
     *   2: Year,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'previous year' => [
                false,
                Year::fromString('2022'),
                Year::fromString('2021'),
            ],
            'same date' => [
                true,
                Year::fromString('2022'),
                Year::fromString('2022'),
            ],
            'next year' => [
                true,
                Year::fromString('2022'),
                Year::fromString('2023'),
            ],
        ];
    }
}
