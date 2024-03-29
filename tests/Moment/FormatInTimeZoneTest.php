<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Moment */
final class FormatInTimeZoneTest extends TestCase
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
        Moment $dateTime,
        string $format,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $dateTime->formatInTimeZone($format, $timeZone));
    }

    /**
     * @return array<string, array{
     *   0: string,
     *   1: Moment,
     *   2: string,
     *   3: \DateTimeZone,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'format to atom' => [
                '2022-10-08T15:00:00+00:00',
                Moment::fromString('2022-10-08 15:00:00'),
                \DateTimeInterface::ATOM,
                new \DateTimeZone('UTC'),
            ],
            'format to date format' => [
                '2022-10-08',
                Moment::fromString('2022-10-08 15:00:00'),
                'Y-m-d',
                new \DateTimeZone('UTC'),
            ],
            'format time' => [
                '15:00:00',
                Moment::fromString('2022-10-08 15:00:00'),
                'H:i:s',
                new \DateTimeZone('UTC'),
            ],
            'format time in time zone Europe/Berlin' => [
                '17:00:00',
                Moment::fromString('2022-10-08 15:00:00'),
                'H:i:s',
                new \DateTimeZone('Europe/Berlin'),
            ],
            'format time of date time in time zone Europe/Berlin for time zone Europe/Berlin' => [
                '15:00:00',
                Moment::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin')),
                'H:i:s',
                new \DateTimeZone('Europe/Berlin'),
            ],
        ];
    }
}
