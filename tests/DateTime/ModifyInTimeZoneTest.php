<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\DateTime;

use DigitalCraftsman\DateTimePrecision\DateTime;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\DateTime */
final class ModifyInTimeZoneTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::modifyInTimeZone
     */
    public function modify_in_time_zone_works(
        DateTime $expectedResult,
        DateTime $dateTime,
        \DateTimeZone $timeZone,
        string $modifier,
    ): void {
        // -- Act & Assert
        self::assertTrue($expectedResult->isEqualTo($dateTime->modifyInTimeZone($modifier, $timeZone)));
    }

    /**
     * @return array<string, array{
     *   0: DateTime,
     *   1: DateTime,
     *   2: \DateTimeZone,
     *   3: string,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'subtract 15 minutes' => [
                DateTime::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin')),
                DateTime::fromStringInTimeZone('2022-10-08 15:15:00', new \DateTimeZone('Europe/Berlin')),
                new \DateTimeZone('Europe/Berlin'),
                '- 15 minutes',
            ],
            'subtract 14 days over the summer winter switch' => [
                DateTime::fromStringInTimeZone('2022-02-15 00:00:00', new \DateTimeZone('Europe/Berlin')),
                DateTime::fromStringInTimeZone('2022-03-01 00:00:00', new \DateTimeZone('Europe/Berlin')),
                new \DateTimeZone('Europe/Berlin'),
                '- 14 days',
            ],
            'add one month' => [
                DateTime::fromStringInTimeZone('2022-11-08 15:00:00', new \DateTimeZone('Europe/Berlin')),
                DateTime::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin')),
                new \DateTimeZone('Europe/Berlin'),
                '+ 1 month',
            ],
            'subtract 14 days over the summer winter switch from UTC' => [
                DateTime::fromString('2022-03-18 23:00:00'),
                DateTime::fromString('2022-04-01 22:00:00'),
                new \DateTimeZone('Europe/Berlin'),
                '- 14 days',
            ],
        ];
    }
}
