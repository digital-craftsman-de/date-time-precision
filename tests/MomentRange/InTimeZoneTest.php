<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\MomentRange;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\DateRange;
use DigitalCraftsman\DateTimePrecision\Exception\MomentRangeIsLongerThanADay;
use DigitalCraftsman\DateTimePrecision\Exception\TimeRangeStartIsEqualToEnd;
use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\MomentRange;
use DigitalCraftsman\DateTimePrecision\Time;
use DigitalCraftsman\DateTimePrecision\TimeRange;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(MomentRange::class)]
#[CoversClass(MomentRangeIsLongerThanADay::class)]
final class InTimeZoneTest extends TestCase
{
    #[Test]
    #[DataProvider('dateRangeDataProvider')]
    public function date_range_in_time_zone_works(
        string $expectedStart,
        string $expectedEnd,
        string $start,
        string $end,
    ): void {
        // -- Arrange
        $momentRange = new MomentRange(Moment::fromString($start), Moment::fromString($end));

        // -- Act & Assert
        self::assertEquals(
            new DateRange(Date::fromString($expectedStart), Date::fromString($expectedEnd)),
            $momentRange->dateRangeInTimeZone(new \DateTimeZone('Europe/Berlin')),
        );
    }

    /**
     * @return array<string, array{
     *   0: string,
     *   1: string,
     *   2: string,
     *   3: string,
     * }>
     */
    public static function dateRangeDataProvider(): array
    {
        return [
            'within a single day' => [
                '2026-01-01',
                '2026-01-01',
                '2026-01-01 10:00:00',
                '2026-01-01 12:00:00',
            ],
            'start on following day in time zone' => [
                '2026-01-02',
                '2026-01-02',
                '2026-01-01 23:30:00',
                '2026-01-02 10:00:00',
            ],
            'end at midnight in time zone is excluded' => [
                '2026-01-01',
                '2026-01-01',
                '2026-01-01 10:00:00',
                '2026-01-01 23:00:00',
            ],
            'end just after midnight in time zone' => [
                '2026-01-01',
                '2026-01-02',
                '2026-01-01 10:00:00',
                '2026-01-01 23:00:00.000001',
            ],
        ];
    }

    #[Test]
    #[DataProvider('timeRangeDataProvider')]
    public function time_range_in_time_zone_works(
        string $expectedStart,
        string $expectedEnd,
        string $start,
        string $end,
    ): void {
        // -- Arrange
        $momentRange = new MomentRange(Moment::fromString($start), Moment::fromString($end));

        // -- Act & Assert
        self::assertEquals(
            new TimeRange(Time::fromString($expectedStart), Time::fromString($expectedEnd)),
            $momentRange->timeRangeInTimeZone(new \DateTimeZone('Europe/Berlin')),
        );
    }

    /**
     * @return array<string, array{
     *   0: string,
     *   1: string,
     *   2: string,
     *   3: string,
     * }>
     */
    public static function timeRangeDataProvider(): array
    {
        return [
            'within a day' => [
                '11:00:00',
                '13:00:00',
                '2026-01-01 10:00:00',
                '2026-01-01 12:00:00',
            ],
            'wraps around midnight in time zone' => [
                '22:00:00',
                '02:00:00',
                '2026-01-01 21:00:00',
                '2026-01-02 01:00:00',
            ],
            'full day with 25 hours on change to winter time' => [
                '00:00:00',
                '00:00:00',
                '2026-10-24 22:00:00',
                '2026-10-25 23:00:00',
            ],
        ];
    }

    #[Test]
    public function time_range_in_time_zone_fails_when_longer_than_a_day(): void
    {
        // -- Arrange
        $momentRange = new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-02 10:00:00.000001'));

        // -- Assert
        $this->expectException(MomentRangeIsLongerThanADay::class);

        // -- Act
        $momentRange->timeRangeInTimeZone(new \DateTimeZone('Europe/Berlin'));
    }

    #[Test]
    public function time_range_in_time_zone_fails_when_exactly_one_day_not_starting_at_midnight(): void
    {
        // -- Arrange
        $momentRange = new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-02 10:00:00'));

        // -- Assert
        $this->expectException(TimeRangeStartIsEqualToEnd::class);

        // -- Act
        $momentRange->timeRangeInTimeZone(new \DateTimeZone('Europe/Berlin'));
    }
}
