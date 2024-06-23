<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Exception\MomentIsAfter;
use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\Month;
use DigitalCraftsman\DateTimePrecision\Test\Exception\CustomMomentIsAfterInTimeZone;
use DigitalCraftsman\DateTimePrecision\Time;
use DigitalCraftsman\DateTimePrecision\Weekday;
use DigitalCraftsman\DateTimePrecision\Year;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Moment */
final class MustNotBeAfterInTimeZoneTest extends TestCase
{
    /**
     * @test
     *
     * @param ?class-string<\Throwable> $expectedResult
     *
     * @dataProvider dataProvider
     *
     * @covers ::mustNotBeAfterInTimeZone
     */
    public function must_not_be_after_in_time_zone_works(
        ?string $expectedResult,
        Moment $moment,
        Time | Weekday | Date | Month | Year $comparator,
        \DateTimeZone $timeZone,
        ?callable $otherwiseThrow,
    ): void {
        // -- Act & Assert
        if ($expectedResult !== null) {
            $this->expectException($expectedResult);
        } else {
            $this->expectNotToPerformAssertions();
        }

        $moment->mustNotBeAfterInTimeZone(
            $comparator,
            $timeZone,
            $otherwiseThrow,
        );
    }

    /**
     * @return array<string, array{
     *   0: ?string,
     *   1: Moment,
     *   2: Time | Weekday | Date | Month | Year,
     *   3: \DateTimeZone,
     *   4: ?callable(): \Throwable
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'without exception' => [
                null,
                Moment::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin')),
                Time::fromString('15:00:00'),
                new \DateTimeZone('Europe/Berlin'),
                null,
            ],
            'default exception' => [
                MomentIsAfter::class,
                Moment::fromStringInTimeZone('2022-10-08 16:00:00', new \DateTimeZone('Europe/Berlin')),
                Time::fromString('15:00:00'),
                new \DateTimeZone('Europe/Berlin'),
                null,
            ],
            'custom exception' => [
                CustomMomentIsAfterInTimeZone::class,
                Moment::fromStringInTimeZone('2022-10-08 16:00:00', new \DateTimeZone('Europe/Berlin')),
                Time::fromString('15:00:00'),
                new \DateTimeZone('Europe/Berlin'),
                static fn () => new CustomMomentIsAfterInTimeZone(),
            ],
        ];
    }
}
