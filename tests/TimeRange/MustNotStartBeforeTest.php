<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\TimeRange;

use DigitalCraftsman\DateTimePrecision\Exception\TimeRangeStartIsBefore;
use DigitalCraftsman\DateTimePrecision\Test\Exception\CustomTimeRangeStartIsBefore;
use DigitalCraftsman\DateTimePrecision\Time;
use DigitalCraftsman\DateTimePrecision\TimeRange;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(TimeRange::class)]
#[CoversClass(TimeRangeStartIsBefore::class)]
final class MustNotStartBeforeTest extends TestCase
{
    /**
     * @param ?class-string<\Throwable> $expectedResult
     */
    #[Test]
    #[DataProvider('dataProvider')]
    public function must_not_start_before_works(
        ?string $expectedResult,
        string $start,
        ?callable $otherwiseThrow,
    ): void {
        // -- Arrange
        $timeRange = new TimeRange(Time::fromString($start), Time::fromString('12:00:00'));

        // -- Act & Assert
        if ($expectedResult !== null) {
            $this->expectException($expectedResult);
        } else {
            $this->expectNotToPerformAssertions();
        }

        $timeRange->mustNotStartBefore(
            Time::fromString('05:00:00'),
            $otherwiseThrow,
        );
    }

    /**
     * @return array<string, array{
     *   0: ?string,
     *   1: string,
     *   2: ?callable(): \Throwable
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'starts at limit' => [
                null,
                '05:00:00',
                null,
            ],
            'starts after limit' => [
                null,
                '08:00:00',
                null,
            ],
            'starts before limit with default exception' => [
                TimeRangeStartIsBefore::class,
                '04:59:59',
                null,
            ],
            'starts at midnight with default exception' => [
                TimeRangeStartIsBefore::class,
                '00:00:00',
                null,
            ],
            'starts before limit with custom exception' => [
                CustomTimeRangeStartIsBefore::class,
                '04:59:59',
                static fn () => new CustomTimeRangeStartIsBefore(),
            ],
        ];
    }
}
