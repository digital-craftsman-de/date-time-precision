<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Dates;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Dates;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Dates::class)]
final class ConstructionTest extends TestCase
{
    #[Test]
    public function construction_works(): void
    {
        // -- Act
        $collection = new Dates([
            Date::fromString('2026-01-01'),
            Date::fromString('2026-01-02'),
            Date::fromString('2026-01-03'),
        ]);

        // -- Assert
        self::assertCount(3, $collection->dates);
    }

    #[Test]
    public function construction_works_without_elements(): void
    {
        // -- Act
        $collection = new Dates([]);

        // -- Assert
        self::assertSame([], $collection->dates);
    }

    #[Test]
    #[DataProvider('dataProvider')]
    public function construction_fails_with_duplicates(
        string $order,
    ): void {
        // -- Arrange
        $elements = match ($order) {
            'duplicate after first' => [
                Date::fromString('2026-01-01'),
                Date::fromString('2026-01-01'),
            ],
            'duplicate of first after other' => [
                Date::fromString('2026-01-01'),
                Date::fromString('2026-01-02'),
                Date::fromString('2026-01-01'),
            ],
            'duplicate of second at the end' => [
                Date::fromString('2026-01-03'),
                Date::fromString('2026-01-02'),
                Date::fromString('2026-01-02'),
            ],
        };

        // -- Assert
        $this->expectException(\InvalidArgumentException::class);

        // -- Act
        new Dates($elements);
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
