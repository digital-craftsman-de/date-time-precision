<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\CalendarUnits;

use DigitalCraftsman\DateTimePrecision\CalendarUnit;
use DigitalCraftsman\DateTimePrecision\CalendarUnits;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(CalendarUnits::class)]
final class ConstructionTest extends TestCase
{
    #[Test]
    public function construction_works(): void
    {
        // -- Act
        $collection = new CalendarUnits([
            CalendarUnit::DAY,
            CalendarUnit::WEEK,
            CalendarUnit::MONTH,
        ]);

        // -- Assert
        self::assertCount(3, $collection->calendarUnits);
    }

    #[Test]
    public function construction_works_without_elements(): void
    {
        // -- Act
        $collection = new CalendarUnits([]);

        // -- Assert
        self::assertSame([], $collection->calendarUnits);
    }

    #[Test]
    #[DataProvider('dataProvider')]
    public function construction_fails_with_duplicates(
        string $order,
    ): void {
        // -- Arrange
        $elements = match ($order) {
            'duplicate after first' => [
                CalendarUnit::DAY,
                CalendarUnit::DAY,
            ],
            'duplicate of first after other' => [
                CalendarUnit::DAY,
                CalendarUnit::WEEK,
                CalendarUnit::DAY,
            ],
            'duplicate of second at the end' => [
                CalendarUnit::MONTH,
                CalendarUnit::WEEK,
                CalendarUnit::WEEK,
            ],
        };

        // -- Assert
        $this->expectException(\DigitalCraftsman\DateTimePrecision\Exception\CollectionContainsDuplicates::class);

        // -- Act
        new CalendarUnits($elements);
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
