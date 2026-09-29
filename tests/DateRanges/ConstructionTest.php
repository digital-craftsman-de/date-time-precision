<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\DateRanges;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\DateRange;
use DigitalCraftsman\DateTimePrecision\DateRanges;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(DateRanges::class)]
final class ConstructionTest extends TestCase
{
    #[Test]
    public function construction_works(): void
    {
        // -- Act
        $collection = new DateRanges([
            new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-10')),
            new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-11')),
            new DateRange(Date::fromString('2026-02-01'), Date::fromString('2026-02-10')),
        ]);

        // -- Assert
        self::assertCount(3, $collection->dateRanges);
    }

    #[Test]
    public function construction_works_without_elements(): void
    {
        // -- Act
        $collection = new DateRanges([]);

        // -- Assert
        self::assertSame([], $collection->dateRanges);
    }

    #[Test]
    #[DataProvider('dataProvider')]
    public function construction_fails_with_duplicates(
        string $order,
    ): void {
        // -- Arrange
        $elements = match ($order) {
            'duplicate after first' => [
                new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-10')),
                new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-10')),
            ],
            'duplicate of first after other' => [
                new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-10')),
                new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-11')),
                new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-10')),
            ],
            'duplicate of second at the end' => [
                new DateRange(Date::fromString('2026-02-01'), Date::fromString('2026-02-10')),
                new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-11')),
                new DateRange(Date::fromString('2026-01-01'), Date::fromString('2026-01-11')),
            ],
        };

        // -- Assert
        $this->expectException(\DigitalCraftsman\DateTimePrecision\Exception\CollectionContainsDuplicates::class);

        // -- Act
        new DateRanges($elements);
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
