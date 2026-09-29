<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Months;

use DigitalCraftsman\DateTimePrecision\Month;
use DigitalCraftsman\DateTimePrecision\Months;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Months::class)]
final class ConstructionTest extends TestCase
{
    #[Test]
    public function construction_works(): void
    {
        // -- Act
        $collection = new Months([
            Month::fromString('2026-01'),
            Month::fromString('2026-02'),
            Month::fromString('2026-03'),
        ]);

        // -- Assert
        self::assertCount(3, $collection->months);
    }

    #[Test]
    public function construction_works_without_elements(): void
    {
        // -- Act
        $collection = new Months([]);

        // -- Assert
        self::assertSame([], $collection->months);
    }

    #[Test]
    #[DataProvider('dataProvider')]
    public function construction_fails_with_duplicates(
        string $order,
    ): void {
        // -- Arrange
        $elements = match ($order) {
            'duplicate after first' => [
                Month::fromString('2026-01'),
                Month::fromString('2026-01'),
            ],
            'duplicate of first after other' => [
                Month::fromString('2026-01'),
                Month::fromString('2026-02'),
                Month::fromString('2026-01'),
            ],
            'duplicate of second at the end' => [
                Month::fromString('2026-03'),
                Month::fromString('2026-02'),
                Month::fromString('2026-02'),
            ],
        };

        // -- Assert
        $this->expectException(\DigitalCraftsman\DateTimePrecision\Exception\CollectionContainsDuplicates::class);

        // -- Act
        new Months($elements);
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
