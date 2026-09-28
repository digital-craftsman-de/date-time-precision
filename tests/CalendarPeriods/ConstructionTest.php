<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\CalendarPeriods;

use DigitalCraftsman\DateTimePrecision\CalendarPeriod;
use DigitalCraftsman\DateTimePrecision\CalendarPeriods;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(CalendarPeriods::class)]
final class ConstructionTest extends TestCase
{
    #[Test]
    public function construction_works(): void
    {
        // -- Act
        $collection = new CalendarPeriods([
            CalendarPeriod::weeks(1),
            CalendarPeriod::days(7),
            CalendarPeriod::days(1),
        ]);

        // -- Assert
        self::assertCount(3, $collection->calendarPeriods);
    }

    #[Test]
    public function construction_works_without_elements(): void
    {
        // -- Act
        $collection = new CalendarPeriods([]);

        // -- Assert
        self::assertSame([], $collection->calendarPeriods);
    }

    #[Test]
    #[DataProvider('dataProvider')]
    public function construction_fails_with_duplicates(
        string $order,
    ): void {
        // -- Arrange
        $elements = match ($order) {
            'duplicate after first' => [
                CalendarPeriod::weeks(1),
                CalendarPeriod::weeks(1),
            ],
            'duplicate of first after other' => [
                CalendarPeriod::weeks(1),
                CalendarPeriod::days(7),
                CalendarPeriod::weeks(1),
            ],
            'duplicate of second at the end' => [
                CalendarPeriod::days(1),
                CalendarPeriod::days(7),
                CalendarPeriod::days(7),
            ],
        };

        // -- Assert
        $this->expectException(\InvalidArgumentException::class);

        // -- Act
        new CalendarPeriods($elements);
    }

    /**
     * @return array<string, array{
     *   0: string,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'duplicate after first' => ['duplicate after first'],
            'duplicate of first after other' => ['duplicate of first after other'],
            'duplicate of second at the end' => ['duplicate of second at the end'],
        ];
    }
}
