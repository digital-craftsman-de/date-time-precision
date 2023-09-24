<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\Time;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Moment */
final class SetTimeTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::setTime
     */
    public function set_time_works(
        Moment $expectedResult,
        Moment $dateTime,
        Time $time,
    ): void {
        // -- Act & Assert
        self::assertTrue($expectedResult->isEqualTo($dateTime->setTime($time)));
    }

    /**
     * @return array<string, array{
     *   0: Moment,
     *   1: Moment,
     *   2: Time,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'set time in UTC' => [
                Moment::fromString('2022-10-08 14:15:30'),
                Moment::fromString('2022-10-08 15:00:00'),
                Time::fromString('14:15:30'),
            ],
            'set time in Europe/Berlin' => [
                Moment::fromDateTime(new \DateTimeImmutable('2022-10-08 14:15:30', new \DateTimeZone('Europe/Berlin'))),
                Moment::fromDateTime(new \DateTimeImmutable('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin'))),
                Time::fromString('14:15:30'),
            ],
        ];
    }
}
