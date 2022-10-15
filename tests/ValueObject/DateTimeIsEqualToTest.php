<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\ValueObject;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\ValueObject\DateTime */
final class DateTimeIsEqualToTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::isEqualTo
     */
    public function is_equal_to_works(
        bool $expectedResult,
        DateTime $dateTime,
        DateTime $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $dateTime->isEqualTo($comparator));
    }

    /**
     * @return array<string, array{
     *   0: boolean,
     *   1: DateTime,
     *   2: DateTime,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'is equal' => [
                true,
                DateTime::fromString('2022-10-08 15:00:00'),
                DateTime::fromString('2022-10-08 15:00:00'),
            ],
            'next year' => [
                false,
                DateTime::fromString('2022-10-08 15:00:00'),
                DateTime::fromString('2023-10-08 15:00:00'),
            ],
            'next month' => [
                false,
                DateTime::fromString('2022-10-08 15:00:00'),
                DateTime::fromString('2022-11-08 15:00:00'),
            ],
            'next day' => [
                false,
                DateTime::fromString('2022-10-08 15:00:00'),
                DateTime::fromString('2022-10-09 15:00:00'),
            ],
            'next hour' => [
                false,
                DateTime::fromString('2022-10-08 15:00:00'),
                DateTime::fromString('2022-10-08 16:00:00'),
            ],
            'next minute' => [
                false,
                DateTime::fromString('2022-10-08 15:00:00'),
                DateTime::fromString('2022-10-08 15:01:00'),
            ],
            'next second' => [
                false,
                DateTime::fromString('2022-10-08 15:00:00'),
                DateTime::fromString('2022-10-08 15:00:01'),
            ],
            'next millisecond' => [
                false,
                DateTime::fromString('2022-10-08 15:00:00'),
                DateTime::fromString('2022-10-08 15:00:00.000001'),
            ],
        ];
    }
}
