<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\DateTime */
final class DateTimeSetTimeTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::setTime
     */
    public function set_time_works(
        DateTime $expectedResult,
        DateTime $dateTime,
        Time $time,
    ): void {
        // -- Act & Assert
        self::assertTrue($expectedResult->isEqualTo($dateTime->setTime($time)));
    }

    /**
     * @return array<string, array{
     *   0: DateTime,
     *   1: DateTime,
     *   2: Time,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'set time in UTC' => [
                DateTime::fromString('2022-10-08 14:15:30'),
                DateTime::fromString('2022-10-08 15:00:00'),
                Time::fromString('14:15:30'),
            ],
            'set time in Europe/Berlin' => [
                DateTime::fromDateTime(new \DateTimeImmutable('2022-10-08 14:15:30', new \DateTimeZone('Europe/Berlin'))),
                DateTime::fromDateTime(new \DateTimeImmutable('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin'))),
                Time::fromString('14:15:30'),
            ],
        ];
    }
}
