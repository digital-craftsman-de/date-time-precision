<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Duration;

use DigitalCraftsman\DateTimePrecision\Duration;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Duration::class)]
final class BetweenTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function between_works(
        Duration $expectedResult,
        \DateTimeImmutable $start,
        \DateTimeImmutable $end,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, Duration::between($start, $end));
    }

    /**
     * @return array<string, array{
     *   0: Duration,
     *   1: \DateTimeImmutable,
     *   2: \DateTimeImmutable,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'same moment' => [
                Duration::zero(),
                new \DateTimeImmutable('2026-01-01 00:00:00.500000', new \DateTimeZone('UTC')),
                new \DateTimeImmutable('2026-01-01 00:00:00.500000', new \DateTimeZone('UTC')),
            ],
            'microseconds across second boundary' => [
                Duration::fromMilliseconds(1_200),
                new \DateTimeImmutable('2026-01-01 00:00:00.900000', new \DateTimeZone('UTC')),
                new \DateTimeImmutable('2026-01-01 00:00:02.100000', new \DateTimeZone('UTC')),
            ],
            'hours with microseconds' => [
                Duration::fromMicroseconds(7_200_000_001),
                new \DateTimeImmutable('2026-01-01 10:00:00.000000', new \DateTimeZone('UTC')),
                new \DateTimeImmutable('2026-01-01 12:00:00.000001', new \DateTimeZone('UTC')),
            ],
            'across change to winter time is elapsed time' => [
                Duration::fromHours(3),
                new \DateTimeImmutable('2026-10-25 01:30:00', new \DateTimeZone('Europe/Berlin')),
                new \DateTimeImmutable('2026-10-25 03:30:00', new \DateTimeZone('Europe/Berlin')),
            ],
        ];
    }
}
