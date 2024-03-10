<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Moment */
final class MidnightTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::midnight
     */
    public function midnight_works(
        Moment $expectedResult,
        Moment $dateTime,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $dateTime->midnight());
    }

    /**
     * @return array<string, array{
     *   0: Moment,
     *   1: Moment,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'midnight from 15:00:00' => [
                Moment::fromString('2022-10-08 00:00:00'),
                Moment::fromString('2022-10-08 15:00:00'),
            ],
            'midnight on first day of year' => [
                Moment::fromString('2022-01-01 00:00:00'),
                Moment::fromString('2022-01-01 14:00:00'),
            ],
            'midnight on time with milliseconds' => [
                Moment::fromString('2022-10-08 00:00:00'),
                Moment::fromString('2022-10-08 15:00:00.023423'),
            ],
            'midnight in specific timezone' => [
                Moment::fromStringInTimeZone('2022-10-08 00:00:00', new \DateTimeZone('Europe/Berlin'))
                    ->toTimeZone(new \DateTimeZone('Europe/Berlin')),
                Moment::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin'))
                    ->toTimeZone(new \DateTimeZone('Europe/Berlin')),
            ],
        ];
    }
}
