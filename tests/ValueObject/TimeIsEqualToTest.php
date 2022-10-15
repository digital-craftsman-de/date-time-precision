<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\ValueObject;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\ValueObject\Time */
final class TimeIsEqualToTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::isEqualTo
     * @covers ::toDateTimeImmutable
     */
    public function is_equal_to_works(
        bool $expectedResult,
        Time $time,
        Time $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $time->isEqualTo($comparator));
    }

    /**
     * @return array<string, array{
     *   0: boolean,
     *   1: Time,
     *   2: Time,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            '1 hour before' => [
                false,
                Time::fromString('15:00:00'),
                Time::fromString('16:00:00'),
            ],
            'same time' => [
                true,
                Time::fromString('15:00:00'),
                Time::fromString('15:00:00'),
            ],
            '1 hour later' => [
                false,
                Time::fromString('16:00:00'),
                Time::fromString('15:00:00'),
            ],
            '1 minute later' => [
                false,
                Time::fromString('15:01:00'),
                Time::fromString('15:00:00'),
            ],
            '1 second later' => [
                false,
                Time::fromString('15:00:01'),
                Time::fromString('15:00:00'),
            ],
            '1 millisecond later' => [
                false,
                Time::fromString('15:00:00.000001'),
                Time::fromString('15:00:00'),
            ],
        ];
    }
}
