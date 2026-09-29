<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\TimeRange;

use DigitalCraftsman\DateTimePrecision\Exception\TimeRangeStartIsEqualToEnd;
use DigitalCraftsman\DateTimePrecision\Time;
use DigitalCraftsman\DateTimePrecision\TimeRange;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(TimeRange::class)]
#[CoversClass(TimeRangeStartIsEqualToEnd::class)]
final class ConstructionTest extends TestCase
{
    /**
     * @param array{
     *   isFullDay: bool,
     *   endsAtMidnight: bool,
     *   wrapsAroundMidnight: bool,
     *   durationInMinutes: int,
     * } $expectedResult
     */
    #[Test]
    #[DataProvider('dataProvider')]
    public function construction_works(
        array $expectedResult,
        string $start,
        string $end,
    ): void {
        // -- Act
        $timeRange = new TimeRange(Time::fromString($start), Time::fromString($end));

        // -- Assert
        self::assertSame($expectedResult['isFullDay'], $timeRange->isFullDay());
        self::assertSame($expectedResult['endsAtMidnight'], $timeRange->endsAtMidnight());
        self::assertSame($expectedResult['wrapsAroundMidnight'], $timeRange->wrapsAroundMidnight());
        self::assertSame($expectedResult['durationInMinutes'], $timeRange->duration()->inMinutes());
    }

    /**
     * @return array<string, array{
     *   0: array{
     *     isFullDay: bool,
     *     endsAtMidnight: bool,
     *     wrapsAroundMidnight: bool,
     *     durationInMinutes: int,
     *   },
     *   1: string,
     *   2: string,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'within a day' => [
                [
                    'isFullDay' => false,
                    'endsAtMidnight' => false,
                    'wrapsAroundMidnight' => false,
                    'durationInMinutes' => 90,
                ],
                '10:00:00',
                '11:30:00',
            ],
            'starting at midnight' => [
                [
                    'isFullDay' => false,
                    'endsAtMidnight' => false,
                    'wrapsAroundMidnight' => false,
                    'durationInMinutes' => 360,
                ],
                '00:00:00',
                '06:00:00',
            ],
            'ending at midnight' => [
                [
                    'isFullDay' => false,
                    'endsAtMidnight' => true,
                    'wrapsAroundMidnight' => false,
                    'durationInMinutes' => 180,
                ],
                '21:00:00',
                '00:00:00',
            ],
            'wrapping around midnight' => [
                [
                    'isFullDay' => false,
                    'endsAtMidnight' => false,
                    'wrapsAroundMidnight' => true,
                    'durationInMinutes' => 360,
                ],
                '21:00:00',
                '03:00:00',
            ],
            'full day' => [
                [
                    'isFullDay' => true,
                    'endsAtMidnight' => true,
                    'wrapsAroundMidnight' => false,
                    'durationInMinutes' => 1440,
                ],
                '00:00:00',
                '00:00:00',
            ],
        ];
    }

    #[Test]
    public function construction_fails_when_start_is_equal_to_end(): void
    {
        // -- Assert
        $this->expectException(TimeRangeStartIsEqualToEnd::class);

        // -- Act
        new TimeRange(Time::fromString('10:00:00'), Time::fromString('10:00:00'));
    }
}
