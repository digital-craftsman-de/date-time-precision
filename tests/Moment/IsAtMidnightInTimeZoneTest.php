<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Moment */
final class IsAtMidnightInTimeZoneTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::isAtMidnightInTimeZone
     */
    public function is_at_midnight_in_time_zone_works(
        bool $expectedResult,
        Moment $dateTime,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $dateTime->isAtMidnightInTimeZone($timeZone));
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: Moment,
     *   2: \DateTimeZone,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'midnight at 00:00:00 in UTC' => [
                true,
                Moment::fromString('2022-10-08 00:00:00'),
                new \DateTimeZone('UTC'),
            ],
            'not midnight at 01:00:00 in UTC' => [
                false,
                Moment::fromString('2022-01-01 01:00:00'),
                new \DateTimeZone('UTC'),
            ],
            'not midnight on time with milliseconds in UTC' => [
                false,
                Moment::fromString('2022-10-08 00:00:00.023423'),
                new \DateTimeZone('UTC'),
            ],
            'midnight in specific timezone' => [
                true,
                Moment::fromStringInTimeZone('2022-10-08 00:00:00', new \DateTimeZone('Europe/Berlin')),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'not midnight in specific timezone' => [
                false,
                Moment::fromString('2022-10-08 00:00:00'),
                new \DateTimeZone('Europe/Berlin'),
            ],
        ];
    }
}
