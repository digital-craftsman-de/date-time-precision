<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\DateTime;

use DigitalCraftsman\DateTimeParts\DateTime;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\DateTime */
final class DateTimeFormatInTimeZoneTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::formatInTimeZone
     */
    public function format_in_time_zone_works(
        string $expectedResult,
        DateTime $dateTime,
        string $format,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $dateTime->formatInTimeZone($format, $timeZone));
    }

    /**
     * @return array<string, array{
     *   0: string,
     *   1: DateTime,
     *   2: string,
     *   3: \DateTimeZone,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'format to atom' => [
                '2022-10-08T15:00:00+00:00',
                DateTime::fromString('2022-10-08 15:00:00'),
                \DateTimeInterface::ATOM,
                new \DateTimeZone('UTC'),
            ],
            'format to date format' => [
                '2022-10-08',
                DateTime::fromString('2022-10-08 15:00:00'),
                'Y-m-d',
                new \DateTimeZone('UTC'),
            ],
            'format time' => [
                '15:00:00',
                DateTime::fromString('2022-10-08 15:00:00'),
                'H:i:s',
                new \DateTimeZone('UTC'),
            ],
            'format time in time zone Europe/Berlin' => [
                '17:00:00',
                DateTime::fromString('2022-10-08 15:00:00'),
                'H:i:s',
                new \DateTimeZone('Europe/Berlin'),
            ],
            'format time of date time in time zone Europe/Berlin for time zone Europe/Berlin' => [
                '15:00:00',
                DateTime::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin')),
                'H:i:s',
                new \DateTimeZone('Europe/Berlin'),
            ],
        ];
    }
}
