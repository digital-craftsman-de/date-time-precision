<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\DateTime */
final class DateTimeIsNotAtMidnightInTimeZoneTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::isNotAtMidnightInTimeZone
     */
    public function is_not_at_midnight_in_time_zone_works(
        bool $expectedResult,
        DateTime $dateTime,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $dateTime->isNotAtMidnightInTimeZone($timeZone));
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: DateTime,
     *   2: \DateTimeZone,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'midnight at 00:00:00 in UTC' => [
                false,
                DateTime::fromString('2022-10-08 00:00:00'),
                new \DateTimeZone('UTC'),
            ],
            'not midnight at 01:00:00 in UTC' => [
                true,
                DateTime::fromString('2022-01-01 01:00:00'),
                new \DateTimeZone('UTC'),
            ],
            'not midnight on time with milliseconds in UTC' => [
                true,
                DateTime::fromString('2022-10-08 00:00:00.023423'),
                new \DateTimeZone('UTC'),
            ],
            'midnight in specific timezone' => [
                false,
                DateTime::fromStringInTimeZone('2022-10-08 00:00:00', new \DateTimeZone('Europe/Berlin')),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'not midnight in specific timezone' => [
                true,
                DateTime::fromString('2022-10-08 00:00:00'),
                new \DateTimeZone('Europe/Berlin'),
            ],
        ];
    }
}
