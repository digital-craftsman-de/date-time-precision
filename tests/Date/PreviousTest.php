<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\CalendarPeriod;
use DigitalCraftsman\DateTimePrecision\Date;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Date::class)]
#[CoversClass(CalendarPeriod::class)]
final class PreviousTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function previous_works(
        Date $expectedResult,
        Date $date,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $date->previous());
    }

    /**
     * @return array<string, array{
     *   0: Date,
     *   1: Date,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'within month' => [
                Date::fromString('2026-03-14'),
                Date::fromString('2026-03-15'),
            ],
            'across leap day' => [
                Date::fromString('2024-02-29'),
                Date::fromString('2024-03-01'),
            ],
            'across year' => [
                Date::fromString('2026-12-31'),
                Date::fromString('2027-01-01'),
            ],
        ];
    }
}
