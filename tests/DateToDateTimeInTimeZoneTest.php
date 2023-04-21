<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\Date */
final class DateToDateTimeInTimeZoneTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::toDateTimeInTimeZone
     */
    public function format_works(
        DateTime $expectedResult,
        Date $date,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $date->toDateTimeInTimeZone($timeZone));
    }

    /**
     * @return array<string, array{
     *   0: DateTime,
     *   1: Date,
     *   2: \DateTimeZone,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            '2. october 2022 in Europe/Berlin' => [
                DateTime::fromStringInTimeZone('2022-10-02 00:00:00', new \DateTimeZone('Europe/Berlin')),
                Date::fromString('2022-10-02'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            '2. october 2023 in UTC' => [
                DateTime::fromStringInTimeZone('2023-10-02 00:00:00', new \DateTimeZone('UTC')),
                Date::fromString('2023-10-02'),
                new \DateTimeZone('UTC'),
            ],
        ];
    }
}
