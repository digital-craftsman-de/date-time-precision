<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Weekday;

use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\Weekday;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Weekday */
final class ConstructionTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::fromDateTime
     */
    public function from_date_time_works(
        Weekday $expectedResult,
        Moment $moment,
    ): void {
        // -- Act & Assert
        self::assertTrue($expectedResult->isEqualTo(Weekday::fromDateTime($moment->dateTime)));
    }

    /**
     * @return array<string, array{
     *   0: Weekday,
     *   1: Moment,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'monday' => [
                Weekday::MONDAY,
                Moment::fromString('2022-10-10 22:15:00'),
            ],
            'tuesday' => [
                Weekday::TUESDAY,
                Moment::fromString('2022-10-11 22:15:00'),
            ],
            'wednesday' => [
                Weekday::WEDNESDAY,
                Moment::fromString('2022-10-12 22:15:00'),
            ],
            'thursday' => [
                Weekday::THURSDAY,
                Moment::fromString('2022-10-13 22:15:00'),
            ],
            'friday' => [
                Weekday::FRIDAY,
                Moment::fromString('2022-10-14 22:15:00'),
            ],
            'saturday' => [
                Weekday::SATURDAY,
                Moment::fromString('2022-10-15 22:15:00'),
            ],
            'sunday' => [
                Weekday::SUNDAY,
                Moment::fromString('2022-10-16 22:15:00'),
            ],
        ];
    }
}
