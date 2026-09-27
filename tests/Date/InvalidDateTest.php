<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Day;
use DigitalCraftsman\DateTimePrecision\Exception\InvalidDate;
use DigitalCraftsman\DateTimePrecision\Month;
use DigitalCraftsman\DateTimePrecision\Year;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Date::class)]
#[CoversClass(Month::class)]
#[CoversClass(InvalidDate::class)]
final class InvalidDateTest extends TestCase
{
    #[Test]
    #[DataProvider('validDataProvider')]
    public function construction_works_with_existing_day(
        int $year,
        int $month,
        int $day,
    ): void {
        // -- Act
        $date = new Date(new Month(new Year($year), $month), new Day($day));

        // -- Assert
        self::assertSame(sprintf('%04d-%02d-%02d', $year, $month, $day), $date->normalize());
    }

    /**
     * @return array<string, array{
     *   0: int,
     *   1: int,
     *   2: int,
     * }>
     */
    public static function validDataProvider(): array
    {
        return [
            'last day of january' => [2022, 1, 31],
            'last day of april' => [2022, 4, 30],
            'last day of february' => [2022, 2, 28],
            'leap day' => [2024, 2, 29],
        ];
    }

    #[Test]
    #[DataProvider('invalidDataProvider')]
    public function construction_fails_with_day_not_existing_in_month(
        int $year,
        int $month,
        int $day,
    ): void {
        // -- Assert
        $this->expectException(InvalidDate::class);

        // -- Act
        new Date(new Month(new Year($year), $month), new Day($day));
    }

    /**
     * @return array<string, array{
     *   0: int,
     *   1: int,
     *   2: int,
     * }>
     */
    public static function invalidDataProvider(): array
    {
        return [
            'day 31 in april' => [2022, 4, 31],
            'day 29 in february without leap year' => [2022, 2, 29],
            'day 30 in february of leap year' => [2024, 2, 30],
        ];
    }
}
