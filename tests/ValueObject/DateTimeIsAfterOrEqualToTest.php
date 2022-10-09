<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\ValueObject;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\ValueObject\DateTime */
final class DateTimeIsAfterOrEqualToTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::isAfterOrEqualTo
     */
    public function is_after_or_equal_to_works(
        bool $expectedResult,
        DateTime $dateTime,
        DateTime $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $dateTime->isAfterOrEqualTo($comparator));
    }

    /**
     * @return array<int, array{
     *   0: boolean,
     *   1: DateTime,
     *   2: DateTime,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            [
                false,
                DateTime::fromString('2021-10-08 15:00:00'),
                DateTime::fromString('2022-10-08 15:00:00'),
            ],
            [
                true,
                DateTime::fromString('2022-10-08 15:00:00'),
                DateTime::fromString('2022-10-08 15:00:00'),
            ],
            [
                true,
                DateTime::fromString('2023-10-08 15:00:00'),
                DateTime::fromString('2022-10-08 15:00:00'),
            ],
            [
                true,
                DateTime::fromString('2022-11-08 15:00:00'),
                DateTime::fromString('2022-10-08 15:00:00'),
            ],
            [
                true,
                DateTime::fromString('2022-10-09 15:00:00'),
                DateTime::fromString('2022-10-08 15:00:00'),
            ],
            [
                true,
                DateTime::fromString('2022-10-08 16:00:00'),
                DateTime::fromString('2022-10-08 15:00:00'),
            ],
            [
                true,
                DateTime::fromString('2022-10-08 15:01:00'),
                DateTime::fromString('2022-10-08 15:00:00'),
            ],
            [
                true,
                DateTime::fromString('2022-10-08 15:00:01'),
                DateTime::fromString('2022-10-08 15:00:00'),
            ],
            [
                true,
                DateTime::fromString('2022-10-08 15:00:00.000001'),
                DateTime::fromString('2022-10-08 15:00:00'),
            ],
        ];
    }
}
