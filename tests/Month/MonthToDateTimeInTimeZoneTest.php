<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\Month;

use DigitalCraftsman\DateTimeParts\DateTime;
use DigitalCraftsman\DateTimeParts\Month;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\Month */
final class MonthToDateTimeInTimeZoneTest extends TestCase
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
        Month $month,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $month->toDateTimeInTimeZone($timeZone));
    }

    /**
     * @return array<string, array{
     *   0: DateTime,
     *   1: Month,
     *   2: \DateTimeZone,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'october 2022 in Europe/Berlin' => [
                DateTime::fromStringInTimeZone('2022-10-01 00:00:00', new \DateTimeZone('Europe/Berlin')),
                Month::fromString('2022-10'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'october 2023 in UTC' => [
                DateTime::fromStringInTimeZone('2023-10-01 00:00:00', new \DateTimeZone('UTC')),
                Month::fromString('2023-10'),
                new \DateTimeZone('UTC'),
            ],
        ];
    }
}
