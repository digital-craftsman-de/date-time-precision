<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Date::class)]
final class ToDateTimeInTimeZoneTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function format_works(
        Moment $expectedResult,
        Date $date,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $date->toMomentInTimeZone($timeZone));
    }

    /**
     * @return array<string, array{
     *   0: Moment,
     *   1: Date,
     *   2: \DateTimeZone,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            '2. october 2022 in Europe/Berlin' => [
                Moment::fromStringInTimeZone('2022-10-02 00:00:00', new \DateTimeZone('Europe/Berlin')),
                Date::fromString('2022-10-02'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            '2. october 2023 in UTC' => [
                Moment::fromStringInTimeZone('2023-10-02 00:00:00', new \DateTimeZone('UTC')),
                Date::fromString('2023-10-02'),
                new \DateTimeZone('UTC'),
            ],
        ];
    }
}
