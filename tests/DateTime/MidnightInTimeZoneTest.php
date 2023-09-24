<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\DateTime;

use DigitalCraftsman\DateTimeParts\DateTime;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\DateTime */
final class MidnightInTimeZoneTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::midnightInTimeZone
     */
    public function midnight_works(
        DateTime $expectedResult,
        DateTime $dateTime,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $dateTime->midnightInTimeZone($timeZone));
    }

    /**
     * @return array<string, array{
     *   0: DateTime,
     *   1: DateTime,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'midnight in UTC' => [
                DateTime::fromString('2022-10-08 00:00:00'),
                DateTime::fromString('2022-10-08 15:00:00'),
                new \DateTimeZone('UTC'),
            ],
            'midnight in Europe/Berlin' => [
                DateTime::fromStringInTimeZone('2022-10-08 00:00:00', new \DateTimeZone('Europe/Berlin')),
                DateTime::fromStringInTimeZone('2022-10-08 14:00:00', new \DateTimeZone('Europe/Berlin')),
                new \DateTimeZone('Europe/Berlin'),
            ],
        ];
    }
}
