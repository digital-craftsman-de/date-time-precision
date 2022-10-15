<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\ValueObject;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\ValueObject\Year */
final class YearIsBeforeTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::isBefore
     */
    public function is_before_works(
        bool $expectedResult,
        Year $year,
        Year $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $year->isBefore($comparator));
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
                false,
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
