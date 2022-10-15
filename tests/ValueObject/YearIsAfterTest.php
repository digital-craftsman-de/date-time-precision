<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\ValueObject;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\ValueObject\Year */
final class YearIsAfterTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::isAfter
     */
    public function is_after_works(
        bool $expectedResult,
        Year $year,
        Year $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $year->isAfter($comparator));
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
