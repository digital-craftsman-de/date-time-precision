<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\Year;

use DigitalCraftsman\DateTimeParts\DateTime;
use DigitalCraftsman\DateTimeParts\Year;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\Year */
final class ToDateTimeInTimeZoneTest extends TestCase
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
        Year $year,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $year->toDateTimeInTimeZone($timeZone));
    }

    /**
     * @return array<string, array{
     *   0: DateTime,
     *   1: Year,
     *   2: \DateTimeZone,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'year 2022 in Europe/Berlin' => [
                DateTime::fromStringInTimeZone('2022-01-01 00:00:00', new \DateTimeZone('Europe/Berlin')),
                new Year(2022),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'year 2023 in UTC' => [
                DateTime::fromStringInTimeZone('2023-01-01 00:00:00', new \DateTimeZone('UTC')),
                new Year(2023),
                new \DateTimeZone('UTC'),
            ],
        ];
    }
}
