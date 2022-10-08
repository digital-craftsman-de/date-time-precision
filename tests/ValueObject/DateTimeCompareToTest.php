<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\ValueObject;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\ValueObject\DateTime */
final class DateTimeCompareToTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::compareTo
     */
    public function is_before_works(
        int $expectedResult,
        DateTime $dateTime,
        DateTime $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $dateTime->compareTo($comparator));
    }

    /**
     * @return array<int, array{
     *   0: int,
     *   1: DateTime,
     *   2: DateTime,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            [
                1,
                DateTime::fromString('2022-10-08 15:00:00'),
                DateTime::fromString('2021-10-08 15:00:00'),
            ],
            [
                0,
                DateTime::fromString('2022-10-08 15:00:00'),
                DateTime::fromString('2022-10-08 15:00:00'),
            ],
            [
                -1,
                DateTime::fromString('2022-10-08 15:00:00'),
                DateTime::fromString('2023-10-08 15:00:00'),
            ],
            [
                -1,
                DateTime::fromString('2022-10-08 15:00:00'),
                DateTime::fromString('2022-11-08 15:00:00'),
            ],
            [
                -1,
                DateTime::fromString('2022-10-08 15:00:00'),
                DateTime::fromString('2022-10-09 15:00:00'),
            ],
            [
                -1,
                DateTime::fromString('2022-10-08 15:00:00'),
                DateTime::fromString('2022-10-08 16:00:00'),
            ],
            [
                -1,
                DateTime::fromString('2022-10-08 15:00:00'),
                DateTime::fromString('2022-10-08 15:01:00'),
            ],
            [
                -1,
                DateTime::fromString('2022-10-08 15:00:00'),
                DateTime::fromString('2022-10-08 15:00:01'),
            ],
            [
                -1,
                DateTime::fromString('2022-10-08 15:00:00'),
                DateTime::fromString('2022-10-08 15:00:00.000001'),
            ],
        ];
    }
}
