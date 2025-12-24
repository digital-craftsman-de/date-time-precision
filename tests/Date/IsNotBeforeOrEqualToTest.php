<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\Date;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Date */
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
        Date $date,
        Date $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $date->isNotBeforeOrEqualTo($comparator));
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: Date,
     *   2: Date,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'previous year' => [
                true,
                Date::fromString('2022-10-08'),
                Date::fromString('2021-10-08'),
            ],
            'same date' => [
                false,
                Date::fromString('2022-10-08'),
                Date::fromString('2022-10-08'),
            ],
            'next year' => [
                false,
                Date::fromString('2022-10-08'),
                Date::fromString('2023-10-08'),
            ],
            'next month' => [
                false,
                Date::fromString('2022-10-08'),
                Date::fromString('2022-11-08'),
            ],
            'next day' => [
                false,
                Date::fromString('2022-10-08'),
                Date::fromString('2022-10-09'),
            ],
        ];
    }
}
