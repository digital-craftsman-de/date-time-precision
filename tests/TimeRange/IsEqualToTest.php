<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\TimeRange;

use DigitalCraftsman\DateTimePrecision\Time;
use DigitalCraftsman\DateTimePrecision\TimeRange;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(TimeRange::class)]
final class IsEqualToTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function is_equal_to_works(
        bool $expectedResult,
        string $start,
        string $end,
    ): void {
        // -- Arrange
        $timeRange = new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00'));
        $otherTimeRange = new TimeRange(Time::fromString($start), Time::fromString($end));

        // -- Act & Assert
        self::assertSame($expectedResult, $timeRange->isEqualTo($otherTimeRange));
        self::assertSame(!$expectedResult, $timeRange->isNotEqualTo($otherTimeRange));
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: string,
     *   2: string,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'same' => [true, '10:00:00', '12:00:00'],
            'different start' => [false, '10:00:01', '12:00:00'],
            'different end' => [false, '10:00:00', '12:00:01'],
        ];
    }
}
