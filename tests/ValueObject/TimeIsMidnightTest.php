<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\ValueObject;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\ValueObject\Time */
final class TimeIsMidnightTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::isMidnight
     */
    public function is_midnight_works(
        bool $expectedResult,
        Time $time,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $time->isMidnight());
    }

    /**
     * @return array<string, array{
     *   0: boolean,
     *   1: Time,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'at midnight' => [
                true,
                Time::fromString('00:00:00'),
            ],
            'not at midnight' => [
                false,
                Time::fromString('15:00:00'),
            ],
        ];
    }
}
