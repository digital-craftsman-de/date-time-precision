<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Moment */
final class ToTimeZoneTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::toTimeZone
     */
    public function to_time_zone_works(
        Moment $expectedResult,
        Moment $dateTime,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertTrue($expectedResult->isEqualTo($dateTime->toTimeZone($timeZone)));
    }

    /**
     * @return array<string, array{
     *   0: Moment,
     *   1: Moment,
     *   2: \DateTimeZone,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'from UTC to Europe/Berlin' => [
                Moment::fromDateTime(new \DateTimeImmutable('2022-10-08 17:00:00', new \DateTimeZone('Europe/Berlin'))),
                Moment::fromString('2022-10-08 15:00:00'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'from Europe/Berlin to UTC' => [
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromDateTime(new \DateTimeImmutable('2022-10-08 17:00:00', new \DateTimeZone('Europe/Berlin'))),
                new \DateTimeZone('UTC'),
            ],
        ];
    }
}
