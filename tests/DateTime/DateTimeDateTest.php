<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\DateTime;

use DigitalCraftsman\DateTimeParts\Date;
use DigitalCraftsman\DateTimeParts\DateTime;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\DateTime */
final class DateTimeDateTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProviderForDate
     *
     * @covers ::date
     */
    public function date_works(
        Date $expectedResult,
        DateTime $dateTime,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $dateTime->date());
    }

    /**
     * @return array<string, array{
     *   0: Date,
     *   1: DateTime,
     * }>
     */
    public function dataProviderForDate(): array
    {
        return [
            'same date in UTC' => [
                Date::fromString('2022-10-08'),
                DateTime::fromString('2022-10-08 00:00:00'),
            ],
            'date the same with same time zone' => [
                Date::fromString('2022-10-08'),
                DateTime::fromStringInTimeZone('2022-10-08 01:00:00', new \DateTimeZone('Europe/Berlin'))
                    ->toTimeZone(new \DateTimeZone('Europe/Berlin')),
            ],
        ];
    }

    /**
     * @test
     *
     * @dataProvider dataProviderForDateInTimeZone
     *
     * @covers ::dateInTimeZone
     */
    public function date_in_time_zone_works(
        Date $expectedResult,
        DateTime $dateTime,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $dateTime->dateInTimeZone($timeZone));
    }

    /**
     * @return array<string, array{
     *   0: Date,
     *   1: DateTime,
     *   2: \DateTimeZone,
     * }>
     */
    public function dataProviderForDateInTimeZone(): array
    {
        return [
            'same date in UTC' => [
                Date::fromString('2022-10-08'),
                DateTime::fromString('2022-10-08 00:00:00'),
                new \DateTimeZone('UTC'),
            ],
            'adapting date depending two hours through timezone difference' => [
                Date::fromString('2022-10-08'),
                DateTime::fromString('2022-10-07 23:00:00'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'same date when timezone was used for creation of datetime' => [
                Date::fromString('2022-10-08'),
                DateTime::fromStringInTimeZone('2022-10-08 00:00:00', new \DateTimeZone('Europe/Berlin')),
                new \DateTimeZone('Europe/Berlin'),
            ],
        ];
    }
}
