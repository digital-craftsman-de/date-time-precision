<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\DateTime;

use DigitalCraftsman\DateTimeParts\DateTime;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\DateTime */
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
        DateTime $expectedResult,
        DateTime $dateTime,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $dateTime->midnight());
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
            'midnight from 15:00:00' => [
                DateTime::fromString('2022-10-08 00:00:00'),
                DateTime::fromString('2022-10-08 15:00:00'),
            ],
            'midnight on first day of year' => [
                DateTime::fromString('2022-01-01 00:00:00'),
                DateTime::fromString('2022-01-01 14:00:00'),
            ],
            'midnight on time with milliseconds' => [
                DateTime::fromString('2022-10-08 00:00:00'),
                DateTime::fromString('2022-10-08 15:00:00.023423'),
            ],
            'midnight in specific timezone' => [
                DateTime::fromStringInTimeZone('2022-10-08 00:00:00', new \DateTimeZone('Europe/Berlin'))
                    ->toTimeZone(new \DateTimeZone('Europe/Berlin')),
                DateTime::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin'))
                    ->toTimeZone(new \DateTimeZone('Europe/Berlin')),
            ],
        ];
    }
}
