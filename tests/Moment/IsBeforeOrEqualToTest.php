<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Moment */
final class IsBeforeOrEqualToTest extends TestCase
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
        Moment $dateTime,
        Moment $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $dateTime->isBeforeOrEqualTo($comparator));
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: Moment,
     *   2: Moment,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'previous year' => [
                false,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2021-10-08 15:00:00'),
            ],
            'is equal' => [
                true,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2022-10-08 15:00:00'),
            ],
            'next year' => [
                true,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2023-10-08 15:00:00'),
            ],
            'next month' => [
                true,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2022-11-08 15:00:00'),
            ],
            'next day' => [
                true,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2022-10-09 15:00:00'),
            ],
            'next hour' => [
                true,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2022-10-08 16:00:00'),
            ],
            'next minute' => [
                true,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2022-10-08 15:01:00'),
            ],
            'next second' => [
                true,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2022-10-08 15:00:01'),
            ],
            'next millisecond' => [
                true,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2022-10-08 15:00:00.000001'),
            ],
        ];
    }
}
