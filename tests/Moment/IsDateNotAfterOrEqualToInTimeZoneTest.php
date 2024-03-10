<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Moment */
final class IsDateNotAfterOrEqualToInTimeZoneTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::isDateNotAfterOrEqualToInTimeZone
     */
    public function is_date_not_after_or_equal_to_in_time_zone_works(
        bool $expectedResult,
        Moment $dateTime,
        Moment $comparator,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $dateTime->isDateNotAfterOrEqualToInTimeZone($comparator, $timeZone));
    }

    /**
     * @return array<string, array{
     *   0: boolean,
     *   1: Moment,
     *   2: Moment,
     *   3: \DateTimeZone
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'previous day in UTC' => [
                true,
                Moment::fromString('2022-10-07 00:00:00'),
                Moment::fromString('2022-10-08 15:00:00'),
                new \DateTimeZone('UTC'),
            ],
            'previous day in Europe/Berlin' => [
                true,
                Moment::fromStringInTimeZone('2022-10-07 00:00:00', new \DateTimeZone('Europe/Berlin')),
                Moment::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin')),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'same day in UTC' => [
                false,
                Moment::fromString('2022-10-08 00:00:00'),
                Moment::fromString('2022-10-08 15:00:00'),
                new \DateTimeZone('UTC'),
            ],
            'same day in Europe/Berlin' => [
                false,
                Moment::fromStringInTimeZone('2022-10-08 00:00:00', new \DateTimeZone('Europe/Berlin')),
                Moment::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin')),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'next day in UTC' => [
                false,
                Moment::fromString('2022-10-08 00:00:00'),
                Moment::fromString('2022-10-07 15:00:00'),
                new \DateTimeZone('UTC'),
            ],
            'next day in Europe/Berlin' => [
                false,
                Moment::fromStringInTimeZone('2022-10-08 00:00:00', new \DateTimeZone('Europe/Berlin')),
                Moment::fromStringInTimeZone('2022-10-07 15:00:00', new \DateTimeZone('Europe/Berlin')),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'next day in Europe/Berlin when partially in Europe/Berlin' => [
                false,
                Moment::fromStringInTimeZone('2022-10-08 00:00:00', new \DateTimeZone('Europe/Berlin')),
                Moment::fromStringInTimeZone('2022-10-07 15:00:00', new \DateTimeZone('Europe/Berlin'))
                    ->toTimeZone(new \DateTimeZone('Europe/Berlin')),
                new \DateTimeZone('Europe/Berlin'),
            ],
        ];
    }
}
