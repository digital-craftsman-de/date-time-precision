<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Year;

use DigitalCraftsman\DateTimePrecision\CalendarPeriod;
use DigitalCraftsman\DateTimePrecision\Exception\CalendarUnitIsNotSupported;
use DigitalCraftsman\DateTimePrecision\Year;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Year::class)]
#[CoversClass(CalendarPeriod::class)]
#[CoversClass(CalendarUnitIsNotSupported::class)]
final class AddTest extends TestCase
{
    #[Test]
    public function add_works(): void
    {
        // -- Act & Assert
        self::assertEquals(new Year(2028), new Year(2026)->add(CalendarPeriod::years(2)));
        self::assertEquals(new Year(2026), new Year(2026)->add(CalendarPeriod::years(0)));
    }

    #[Test]
    public function subtract_works(): void
    {
        // -- Act & Assert
        self::assertEquals(new Year(2024), new Year(2026)->subtract(CalendarPeriod::years(2)));
    }

    #[Test]
    public function next_and_previous_works(): void
    {
        // -- Act & Assert
        self::assertEquals(new Year(2027), new Year(2026)->next());
        self::assertEquals(new Year(2025), new Year(2026)->previous());
    }

    #[Test]
    #[DataProvider('unsupportedDataProvider')]
    public function add_fails_with_unsupported_calendar_unit(
        CalendarPeriod $calendarPeriod,
    ): void {
        // -- Assert
        $this->expectException(CalendarUnitIsNotSupported::class);

        // -- Act
        new Year(2026)->add($calendarPeriod);
    }

    #[Test]
    #[DataProvider('unsupportedDataProvider')]
    public function subtract_fails_with_unsupported_calendar_unit(
        CalendarPeriod $calendarPeriod,
    ): void {
        // -- Assert
        $this->expectException(CalendarUnitIsNotSupported::class);

        // -- Act
        new Year(2026)->subtract($calendarPeriod);
    }

    /**
     * @return array<string, array{
     *   0: CalendarPeriod,
     * }>
     */
    public static function unsupportedDataProvider(): array
    {
        return [
            'days' => [CalendarPeriod::days(1)],
            'weeks' => [CalendarPeriod::weeks(1)],
            'months' => [CalendarPeriod::months(12)],
            'quarters' => [CalendarPeriod::quarters(4)],
        ];
    }
}
