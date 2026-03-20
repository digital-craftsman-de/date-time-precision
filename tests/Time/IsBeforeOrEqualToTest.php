<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Time;

use DigitalCraftsman\DateTimePrecision\Time;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Time::class)]
final class IsBeforeOrEqualToTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function is_before_or_equal_to_works(
        bool $expectedResult,
        Time $time,
        Time $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $time->isBeforeOrEqualTo($comparator));
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: Time,
     *   2: Time,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            '1 hour after' => [
                false,
                Time::fromString('16:00:00'),
                Time::fromString('15:00:00'),
            ],
            'same time' => [
                true,
                Time::fromString('15:00:00'),
                Time::fromString('15:00:00'),
            ],
            '1 hour before' => [
                true,
                Time::fromString('15:00:00'),
                Time::fromString('16:00:00'),
            ],
            '1 minute before' => [
                true,
                Time::fromString('15:00:00'),
                Time::fromString('15:01:00'),
            ],
            '1 second before' => [
                true,
                Time::fromString('15:00:00'),
                Time::fromString('15:00:01'),
            ],
            '1 millisecond before' => [
                true,
                Time::fromString('15:00:00'),
                Time::fromString('15:00:00.000001'),
            ],
        ];
    }
}
