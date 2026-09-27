<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Duration;
use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Moment::class)]
final class SubtractTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function subtract_works(
        Moment $expectedResult,
        Moment $moment,
        Duration $duration,
    ): void {
        // -- Act
        $result = $moment->subtract($duration);

        // -- Assert
        self::assertTrue($expectedResult->isEqualTo($result));
        self::assertSame($moment->dateTime->getTimezone()->getName(), $result->dateTime->getTimezone()->getName());
    }

    /**
     * @return array<string, array{
     *   0: Moment,
     *   1: Moment,
     *   2: Duration,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'subtract microseconds' => [
                Moment::fromString('2026-06-01 10:00:00.999999'),
                Moment::fromString('2026-06-01 10:00:01.000001'),
                Duration::fromMicroseconds(2),
            ],
            'across change to winter time is elapsed time' => [
                Moment::fromString('2026-10-25 00:30:00'),
                Moment::fromString('2026-10-25 02:30:00'),
                Duration::fromHours(2),
            ],
            'moment in other time zone than UTC is still elapsed time' => [
                Moment::fromString('2026-10-25 00:30:00'),
                Moment::fromDateTime(new \DateTimeImmutable('2026-10-25 03:30:00', new \DateTimeZone('Europe/Berlin'))),
                Duration::fromHours(2),
            ],
        ];
    }
}
