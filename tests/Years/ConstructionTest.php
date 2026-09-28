<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Years;

use DigitalCraftsman\DateTimePrecision\Year;
use DigitalCraftsman\DateTimePrecision\Years;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Years::class)]
final class ConstructionTest extends TestCase
{
    #[Test]
    public function construction_works(): void
    {
        // -- Act
        $collection = new Years([
            new Year(2024),
            new Year(2025),
            new Year(2026),
        ]);

        // -- Assert
        self::assertCount(3, $collection->years);
    }

    #[Test]
    public function construction_works_without_elements(): void
    {
        // -- Act
        $collection = new Years([]);

        // -- Assert
        self::assertSame([], $collection->years);
    }

    #[Test]
    #[DataProvider('dataProvider')]
    public function construction_fails_with_duplicates(
        string $order,
    ): void {
        // -- Arrange
        $elements = match ($order) {
            'duplicate after first' => [
                new Year(2024),
                new Year(2024),
            ],
            'duplicate of first after other' => [
                new Year(2024),
                new Year(2025),
                new Year(2024),
            ],
            'duplicate of second at the end' => [
                new Year(2026),
                new Year(2025),
                new Year(2025),
            ],
        };

        // -- Assert
        $this->expectException(\InvalidArgumentException::class);

        // -- Act
        new Years($elements);
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
