<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\TimeRange;

use DigitalCraftsman\DateTimePrecision\Duration;
use DigitalCraftsman\DateTimePrecision\Exception\DurationIsZero;
use DigitalCraftsman\DateTimePrecision\Time;
use DigitalCraftsman\DateTimePrecision\TimeRange;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(TimeRange::class)]
#[CoversClass(DurationIsZero::class)]
final class IsAlignedToTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function is_aligned_to_works(
        bool $expectedResult,
        string $start,
        string $end,
        string $time,
    ): void {
        // -- Arrange
        $timeRange = new TimeRange(Time::fromString($start), Time::fromString($end));

        // -- Act & Assert
        self::assertSame($expectedResult, $timeRange->isAlignedTo(Time::fromString($time), Duration::fromMinutes(30)));
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: string,
     *   2: string,
     *   3: string,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'start' => [true, '10:00:00', '12:00:00', '10:00:00'],
            'step' => [true, '10:00:00', '12:00:00', '10:30:00'],
            'between steps' => [false, '10:00:00', '12:00:00', '10:15:00'],
            'end is included' => [true, '10:00:00', '12:00:00', '12:00:00'],
            'step after end' => [false, '10:00:00', '12:00:00', '12:30:00'],
            'step before start' => [false, '10:00:00', '12:00:00', '09:30:00'],
            'step after midnight in wrapping range' => [true, '22:00:00', '02:00:00', '01:30:00'],
            'end at midnight' => [true, '22:00:00', '00:00:00', '00:00:00'],
        ];
    }

    #[Test]
    public function is_aligned_to_fails_with_zero_step(): void
    {
        // -- Arrange
        $timeRange = new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00'));

        // -- Assert
        $this->expectException(DurationIsZero::class);

        // -- Act
        $timeRange->isAlignedTo(Time::fromString('10:00:00'), Duration::zero());
    }
}
