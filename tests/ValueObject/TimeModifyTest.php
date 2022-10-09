<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\ValueObject;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\ValueObject\Time */
final class TimeModifyTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::modify
     */
    public function modify_works(
        Time $expectedResult,
        Time $time,
        string $modifier,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $time->modify($modifier));
    }

    /**
     * @return array<string, array{
     *   0: Time,
     *   1: Time,
     *   2: string,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'subtract one minute' => [
                Time::fromString('14:59:00'),
                Time::fromString('15:00:00'),
                '- 1 minute',
            ],
            'add one minute' => [
                Time::fromString('15:01:00'),
                Time::fromString('15:00:00'),
                '+ 1 minute',
            ],
            'add one hour' => [
                Time::fromString('16:00:00'),
                Time::fromString('15:00:00'),
                '+ 1 hour',
            ],
            'add hours over the day' => [
                Time::fromString('14:00:00'),
                Time::fromString('15:00:00'),
                '+ 23 hours',
            ],
        ];
    }
}
