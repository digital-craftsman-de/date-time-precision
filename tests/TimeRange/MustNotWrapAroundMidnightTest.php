<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\TimeRange;

use DigitalCraftsman\DateTimePrecision\Exception\TimeRangeWrapsAroundMidnight;
use DigitalCraftsman\DateTimePrecision\Test\Exception\CustomTimeRangeWrapsAroundMidnight;
use DigitalCraftsman\DateTimePrecision\Time;
use DigitalCraftsman\DateTimePrecision\TimeRange;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(TimeRange::class)]
#[CoversClass(TimeRangeWrapsAroundMidnight::class)]
final class MustNotWrapAroundMidnightTest extends TestCase
{
    /**
     * @param ?class-string<\Throwable> $expectedResult
     */
    #[Test]
    #[DataProvider('dataProvider')]
    public function must_not_wrap_around_midnight_works(
        ?string $expectedResult,
        string $start,
        string $end,
        ?callable $otherwiseThrow,
    ): void {
        // -- Arrange
        $timeRange = new TimeRange(Time::fromString($start), Time::fromString($end));

        // -- Act & Assert
        if ($expectedResult !== null) {
            $this->expectException($expectedResult);
        } else {
            $this->expectNotToPerformAssertions();
        }

        $timeRange->mustNotWrapAroundMidnight($otherwiseThrow);
    }

    /**
     * @return array<string, array{
     *   0: ?string,
     *   1: string,
     *   2: string,
     *   3: ?callable(): \Throwable
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'within a day' => [
                null,
                '10:00:00',
                '12:00:00',
                null,
            ],
            'ends at midnight' => [
                null,
                '21:00:00',
                '00:00:00',
                null,
            ],
            'full day' => [
                null,
                '00:00:00',
                '00:00:00',
                null,
            ],
            'wraps with default exception' => [
                TimeRangeWrapsAroundMidnight::class,
                '21:00:00',
                '00:00:01',
                null,
            ],
            'wraps with custom exception' => [
                CustomTimeRangeWrapsAroundMidnight::class,
                '21:00:00',
                '03:00:00',
                static fn () => new CustomTimeRangeWrapsAroundMidnight(),
            ],
        ];
    }
}
