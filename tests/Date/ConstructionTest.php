<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Day;
use DigitalCraftsman\DateTimePrecision\Month;
use DigitalCraftsman\DateTimePrecision\Year;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Date::class)]
final class ConstructionTest extends TestCase
{
    #[Test]
    public function construct_works(): void
    {
        // -- Arrange & Act
        $date = new Date(
            new Month(
                new Year(2022),
                10,
            ),
            new Day(
                8,
            ),
        );

        // -- Assert
        self::assertSame(8, $date->day->day);
    }

    #[Test]
    public function from_date_time_works(): void
    {
        // -- Arrange
        $expectedDate = Date::fromString('2022-10-08');
        $dateTimeImmutable = new \DateTimeImmutable('2022-10-08 22:15:00');

        // -- Act
        $date = Date::fromDateTime($dateTimeImmutable);

        // -- Assert
        self::assertTrue($expectedDate->isEqualTo($date));
    }

    #[Test]
    public function from_string_works(): void
    {
        // -- Arrange
        $expectedDate = Date::fromDateTime(new \DateTimeImmutable('2022-10-08 22:15:00'));

        // -- Act
        $date = Date::fromString('2022-10-08');

        // -- Assert
        self::assertTrue($expectedDate->isEqualTo($date));
    }

    #[Test]
    public function from_string_fails(): void
    {
        // -- Assert
        $this->expectException(\InvalidArgumentException::class);

        // -- Arrange & Act
        Date::fromString('invalid date');
    }

    #[Test]
    #[DataProvider('stringsParsedByDateTimeImmutableProvider')]
    public function from_string_follows_date_time_immutable_for_strings_not_being_an_existing_normalized_date(
        string $string,
        string $expectedDate,
    ): void {
        // -- Act
        $date = Date::fromString($string);

        // -- Assert
        self::assertSame($expectedDate, $date->normalize());
        self::assertSame((new \DateTimeImmutable($string))->format('Y-m-d'), $date->normalize());
    }

    /**
     * @return array<string, array{
     *   0: string,
     *   1: string,
     * }>
     */
    public static function stringsParsedByDateTimeImmutableProvider(): array
    {
        return [
            'day not existing in month' => ['2022-02-31', '2022-03-03'],
            'day not existing in month of leap year' => ['2024-02-30', '2024-03-01'],
            'with time' => ['2022-10-08 22:15:00', '2022-10-08'],
            'with relative modification' => ['2022-10-08 +1 day', '2022-10-09'],
            'with more than four digits for the year' => ['12022-10-08', '2002-10-08'],
            'without leading zeros' => ['2022-1-5', '2022-01-05'],
            'relative format' => ['first day of 2022-10', '2022-10-01'],
        ];
    }

    #[Test]
    public function from_string_fails_for_year_zero(): void
    {
        // -- Assert
        $this->expectException(\InvalidArgumentException::class);

        // -- Arrange & Act
        Date::fromString('0000-01-01');
    }
}
