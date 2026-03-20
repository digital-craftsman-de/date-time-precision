<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Moment::class)]
final class MidnightInTimeZoneTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function midnight_works(
        Moment $expectedResult,
        Moment $dateTime,
        \DateTimeZone $timeZone,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $dateTime->midnightInTimeZone($timeZone));
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
            'midnight in UTC' => [
                Moment::fromString('2022-10-08 00:00:00'),
                Moment::fromString('2022-10-08 15:00:00'),
                new \DateTimeZone('UTC'),
            ],
            'midnight in Europe/Berlin' => [
                Moment::fromStringInTimeZone('2022-10-08 00:00:00', new \DateTimeZone('Europe/Berlin')),
                Moment::fromStringInTimeZone('2022-10-08 14:00:00', new \DateTimeZone('Europe/Berlin')),
                new \DateTimeZone('Europe/Berlin'),
            ],
        ];
    }
}
