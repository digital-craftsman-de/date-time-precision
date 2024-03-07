<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\Date;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Date */
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
        Date $date,
        Date $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $date->isNotAfter($comparator));
    }

    /**
     * @return array<string, array{
     *   0: boolean,
     *   1: Date,
     *   2: Date,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'previous year' => [
                true,
                Date::fromString('2021-10-08'),
                Date::fromString('2022-10-08'),
            ],
            'previous day' => [
                true,
                Date::fromString('2022-10-07'),
                Date::fromString('2022-10-08'),
            ],
            'same date' => [
                true,
                Date::fromString('2022-10-08'),
                Date::fromString('2022-10-08'),
            ],
            'next year' => [
                false,
                Date::fromString('2023-10-08'),
                Date::fromString('2022-10-08'),
            ],
            'next month' => [
                false,
                Date::fromString('2022-11-08'),
                Date::fromString('2022-10-08'),
            ],
            'next day' => [
                false,
                Date::fromString('2022-10-09'),
                Date::fromString('2022-10-08'),
            ],
        ];
    }
}
