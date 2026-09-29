<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Week;

use DigitalCraftsman\DateTimePrecision\Exception\InvalidWeek;
use DigitalCraftsman\DateTimePrecision\Week;
use DigitalCraftsman\DateTimePrecision\Year;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Week::class)]
#[CoversClass(InvalidWeek::class)]
final class ConstructionTest extends TestCase
{
    #[Test]
    public function construction_works(): void
    {
        // -- Act
        $week = new Week(new Year(2026), 53);

        // -- Assert
        self::assertSame(2026, $week->year->year);
        self::assertSame(53, $week->week);
        self::assertSame('2026-W01', new Week(new Year(2026), 1)->normalize());
    }

    #[Test]
    #[DataProvider('invalidDataProvider')]
    public function construction_fails_with_invalid_week(
        int $year,
        int $week,
    ): void {
        // -- Assert
        $this->expectException(InvalidWeek::class);

        // -- Act
        new Week(new Year($year), $week);
    }

    /**
     * @return array<string, array{
     *   0: int,
     *   1: int,
     * }>
     */
    public static function invalidDataProvider(): array
    {
        return [
            'week zero' => [2026, 0],
            'week 53 in year with 52 weeks' => [2025, 53],
            'week 54 in year with 53 weeks' => [2026, 54],
        ];
    }

    #[Test]
    #[DataProvider('dateTimeDataProvider')]
    public function from_date_time_works(
        string $expectedResult,
        string $dateTime,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, Week::fromDateTime(new \DateTimeImmutable($dateTime))->normalize());
    }

    /**
     * @return array<string, array{
     *   0: string,
     *   1: string,
     * }>
     */
    public static function dateTimeDataProvider(): array
    {
        return [
            'monday' => ['2026-W10', '2026-03-02 10:00:00'],
            'sunday' => ['2026-W10', '2026-03-08 23:59:59'],
            'end of december in first week of next year' => ['2026-W01', '2025-12-29 00:00:00'],
            'beginning of january in last week of previous year' => ['2026-W53', '2027-01-03 00:00:00'],
        ];
    }

    #[Test]
    public function from_string_works(): void
    {
        // -- Act
        $week = Week::fromString('2026-W09');

        // -- Assert
        self::assertSame(2026, $week->year->year);
        self::assertSame(9, $week->week);
    }

    #[Test]
    #[DataProvider('invalidStringDataProvider')]
    public function from_string_fails_with_invalid_format(
        string $week,
    ): void {
        // -- Assert
        $this->expectException(\InvalidArgumentException::class);

        // -- Act
        Week::fromString($week);
    }

    /**
     * @return array<string, array{
     *   0: string,
     * }>
     */
    public static function invalidStringDataProvider(): array
    {
        return [
            'month format' => ['2026-01'],
            'single digit week' => ['2026-W1'],
            'prefix' => ['x2026-W01'],
            'suffix' => ['2026-W01x'],
            'not existing week' => ['2025-W53'],
        ];
    }

    #[Test]
    public function normalization_works(): void
    {
        // -- Arrange
        $week = Week::fromString('2026-W01');

        // -- Act & Assert
        self::assertSame('2026-W01', $week->normalize());
        self::assertSame('2026-W01', (string) $week);
        self::assertEquals($week, Week::denormalize($week->normalize()));
        self::assertNull(Week::denormalizeWhenNotNull(null));
    }
}
