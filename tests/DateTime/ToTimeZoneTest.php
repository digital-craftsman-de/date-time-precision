<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\DateTime;

use DigitalCraftsman\DateTimePrecision\DateTime;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\DateTime */
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
        DateTime $expectedResult,
        DateTime $dateTime,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertTrue($expectedResult->isEqualTo($dateTime->toTimeZone($timeZone)));
    }

    /**
     * @return array<string, array{
     *   0: DateTime,
     *   1: DateTime,
     *   2: \DateTimeZone,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'from UTC to Europe/Berlin' => [
                DateTime::fromDateTime(new \DateTimeImmutable('2022-10-08 17:00:00', new \DateTimeZone('Europe/Berlin'))),
                DateTime::fromString('2022-10-08 15:00:00'),
                new \DateTimeZone('Europe/Berlin'),
            ],
            'from Europe/Berlin to UTC' => [
                DateTime::fromString('2022-10-08 15:00:00'),
                DateTime::fromDateTime(new \DateTimeImmutable('2022-10-08 17:00:00', new \DateTimeZone('Europe/Berlin'))),
                new \DateTimeZone('UTC'),
            ],
        ];
    }
}
