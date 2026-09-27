<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Weekday;

use DigitalCraftsman\DateTimePrecision\Weekday;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Weekday::class)]
final class NextTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function next_and_previous_works(
        Weekday $weekday,
        Weekday $nextWeekday,
    ): void {
        // -- Act & Assert
        self::assertSame($nextWeekday, $weekday->next());
        self::assertSame($weekday, $nextWeekday->previous());
    }

    /**
     * @return array<string, array{
     *   0: Weekday,
     *   1: Weekday,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'monday' => [Weekday::MONDAY, Weekday::TUESDAY],
            'tuesday' => [Weekday::TUESDAY, Weekday::WEDNESDAY],
            'wednesday' => [Weekday::WEDNESDAY, Weekday::THURSDAY],
            'thursday' => [Weekday::THURSDAY, Weekday::FRIDAY],
            'friday' => [Weekday::FRIDAY, Weekday::SATURDAY],
            'saturday' => [Weekday::SATURDAY, Weekday::SUNDAY],
            'sunday wraps to monday' => [Weekday::SUNDAY, Weekday::MONDAY],
        ];
    }
}
