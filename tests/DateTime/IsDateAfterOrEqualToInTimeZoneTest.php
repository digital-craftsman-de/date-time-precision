<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\DateTime;

use DigitalCraftsman\DateTimePrecision\DateTime;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\DateTime */
final class IsDateAfterOrEqualToInTimeZoneTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::isDateAfterOrEqualToInTimeZone
     */
    public function is_date_after_or_equal_to_in_time_zone_works(
        bool $expectedResult,
        DateTime $dateTime,
        DateTime $comparator,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $dateTime->isDateAfterOrEqualToInTimeZone($comparator, $timeZone));
    }

    /**
     * @return array<string, array{
     *   0: boolean,
     *   1: DateTime,
     *   2: DateTime,
     *   3: \DateTimeZone
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'previous day in UTC' => [
                false,
                DateTime::fromString('2022-10-07 00:00:00'),
                DateTime::fromString('2022-10-08 15:00:00'),
                new \DateTimeZone('UTC'),
            ],
            'previous day in Europe/Berlin' => [
                false,
                DateTime::fromStringInTimeZone('2022-10-07 00:00:00', new \DateTimeZone('Europe/Berlin')),
                DateTime::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin')),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'same day in UTC' => [
                true,
                DateTime::fromString('2022-10-08 00:00:00'),
                DateTime::fromString('2022-10-08 15:00:00'),
                new \DateTimeZone('UTC'),
            ],
            'same day in Europe/Berlin' => [
                true,
                DateTime::fromStringInTimeZone('2022-10-08 00:00:00', new \DateTimeZone('Europe/Berlin')),
                DateTime::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin')),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'next day in UTC' => [
                true,
                DateTime::fromString('2022-10-08 00:00:00'),
                DateTime::fromString('2022-10-07 15:00:00'),
                new \DateTimeZone('UTC'),
            ],
            'next day in Europe/Berlin' => [
                true,
                DateTime::fromStringInTimeZone('2022-10-08 00:00:00', new \DateTimeZone('Europe/Berlin')),
                DateTime::fromStringInTimeZone('2022-10-07 15:00:00', new \DateTimeZone('Europe/Berlin')),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'next day in Europe/Berlin when partially in Europe/Berlin' => [
                true,
                DateTime::fromStringInTimeZone('2022-10-08 00:00:00', new \DateTimeZone('Europe/Berlin')),
                DateTime::fromStringInTimeZone('2022-10-07 15:00:00', new \DateTimeZone('Europe/Berlin'))
                    ->toTimeZone(new \DateTimeZone('Europe/Berlin')),
                new \DateTimeZone('Europe/Berlin'),
            ],
        ];
    }
}
