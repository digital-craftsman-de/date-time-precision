<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Moment */
final class DateInTimeZoneTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProviderForDateInTimeZone
     *
     * @covers ::dateInTimeZone
     */
    public function date_in_time_zone_works(
        Date $expectedResult,
        Moment $dateTime,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $dateTime->dateInTimeZone($timeZone));
    }

    /**
     * @return array<string, array{
     *   0: Date,
     *   1: Moment,
     *   2: \DateTimeZone,
     * }>
     */
    public static function dataProviderForDateInTimeZone(): array
    {
        return [
            'same date in UTC' => [
                Date::fromString('2022-10-08'),
                Moment::fromString('2022-10-08 00:00:00'),
                new \DateTimeZone('UTC'),
            ],
            'adapting date depending two hours through timezone difference' => [
                Date::fromString('2022-10-08'),
                Moment::fromString('2022-10-07 23:00:00'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'same date when timezone was used for creation of datetime' => [
                Date::fromString('2022-10-08'),
                Moment::fromStringInTimeZone('2022-10-08 00:00:00', new \DateTimeZone('Europe/Berlin')),
                new \DateTimeZone('Europe/Berlin'),
            ],
        ];
    }
}
