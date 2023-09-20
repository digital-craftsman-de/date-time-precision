<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\DateTime;

use DigitalCraftsman\DateTimeParts\DateTime;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\DateTime */
final class DateTimeIsAtMidnightTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::isAtMidnight
     */
    public function is_at_midnight_works(
        bool $expectedResult,
        DateTime $dateTime,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $dateTime->isAtMidnight());
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: DateTime,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'midnight at 00:00:00' => [
                true,
                DateTime::fromString('2022-10-08 00:00:00'),
            ],
            'not midnight at 01:00:00' => [
                false,
                DateTime::fromString('2022-01-01 01:00:00'),
            ],
            'not midnight on time with milliseconds' => [
                false,
                DateTime::fromString('2022-10-08 00:00:00.023423'),
            ],
            'midnight in specific timezone' => [
                true,
                DateTime::fromStringInTimeZone('2022-10-08 00:00:00', new \DateTimeZone('Europe/Berlin'))
                    ->toTimeZone(new \DateTimeZone('Europe/Berlin')),
            ],
        ];
    }
}
