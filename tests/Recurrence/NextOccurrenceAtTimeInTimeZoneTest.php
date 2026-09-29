<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Recurrence;

use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\Recurrence;
use DigitalCraftsman\DateTimePrecision\Time;
use DigitalCraftsman\DateTimePrecision\Weekday;
use DigitalCraftsman\DateTimePrecision\Weekdays;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Recurrence::class)]
final class NextOccurrenceAtTimeInTimeZoneTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function next_occurrence_at_time_in_time_zone_works(
        string $expectedResult,
        string $after,
    ): void {
        // -- Arrange
        $recurrence = Recurrence::weekly(new Weekdays([Weekday::MONDAY, Weekday::WEDNESDAY]));
        $timeZone = new \DateTimeZone('Europe/Berlin');

        // -- Act
        $nextOccurrence = $recurrence->nextOccurrenceAtTimeInTimeZone(
            Time::fromString('08:00:00'),
            Moment::fromStringInTimeZone($after, $timeZone),
            $timeZone,
        );

        // -- Assert
        self::assertTrue(Moment::fromStringInTimeZone($expectedResult, $timeZone)->isEqualTo($nextOccurrence));
    }

    /**
     * @return array<string, array{
     *   0: string,
     *   1: string,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'later today' => ['2026-03-02 08:00:00', '2026-03-02 07:59:59'],
            'exactly at time today is excluded' => ['2026-03-04 08:00:00', '2026-03-02 08:00:00'],
            'passed today' => ['2026-03-04 08:00:00', '2026-03-02 09:00:00'],
            'not today' => ['2026-03-04 08:00:00', '2026-03-03 07:00:00'],
            'into next week across change to summer time' => ['2026-03-30 08:00:00', '2026-03-25 09:00:00'],
            'date in time zone differs from UTC' => ['2026-03-02 08:00:00', '2026-03-02 00:30:00'],
        ];
    }
}
