<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Moment */
final class DateTest extends TestCase
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
        Moment $dateTime,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $dateTime->date());
    }

    /**
     * @return array<string, array{
     *   0: Date,
     *   1: Moment,
     * }>
     */
    public function dataProviderForDate(): array
    {
        return [
            'same date in UTC' => [
                Date::fromString('2022-10-08'),
                Moment::fromString('2022-10-08 00:00:00'),
            ],
            'date the same with same time zone' => [
                Date::fromString('2022-10-08'),
                Moment::fromStringInTimeZone('2022-10-08 01:00:00', new \DateTimeZone('Europe/Berlin'))
                    ->toTimeZone(new \DateTimeZone('Europe/Berlin')),
            ],
        ];
    }
}
