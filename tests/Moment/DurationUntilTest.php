<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Duration;
use DigitalCraftsman\DateTimePrecision\Exception\MomentIsBefore;
use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Moment::class)]
#[CoversClass(Duration::class)]
#[CoversClass(MomentIsBefore::class)]
final class DurationUntilTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function duration_until_works(
        Duration $expectedResult,
        Moment $moment,
        Moment $until,
    ): void {
        // -- Act
        $duration = $moment->durationUntil($until);

        // -- Assert
        self::assertEquals($expectedResult, $duration);
        self::assertTrue($until->isEqualTo($moment->add($duration)));
    }

    /**
     * @return array<string, array{
     *   0: Duration,
     *   1: Moment,
     *   2: Moment,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'same moment' => [
                Duration::zero(),
                Moment::fromString('2026-06-01 10:00:00'),
                Moment::fromString('2026-06-01 10:00:00'),
            ],
            'microseconds across seconds' => [
                Duration::fromMilliseconds(1_200),
                Moment::fromString('2026-06-01 10:00:00.900000'),
                Moment::fromString('2026-06-01 10:00:02.100000'),
            ],
            'across change to winter time is elapsed time' => [
                Duration::fromHours(3),
                Moment::fromStringInTimeZone('2026-10-25 01:30:00', new \DateTimeZone('Europe/Berlin')),
                Moment::fromStringInTimeZone('2026-10-25 03:30:00', new \DateTimeZone('Europe/Berlin')),
            ],
            'across change to summer time is elapsed time' => [
                Duration::fromHours(1),
                Moment::fromStringInTimeZone('2026-03-29 01:30:00', new \DateTimeZone('Europe/Berlin')),
                Moment::fromStringInTimeZone('2026-03-29 03:30:00', new \DateTimeZone('Europe/Berlin')),
            ],
        ];
    }

    #[Test]
    public function duration_until_fails_when_moment_is_before(): void
    {
        // -- Assert
        $this->expectException(MomentIsBefore::class);

        // -- Act
        Moment::fromString('2026-06-01 10:00:00')->durationUntil(Moment::fromString('2026-06-01 09:59:59.999999'));
    }
}
