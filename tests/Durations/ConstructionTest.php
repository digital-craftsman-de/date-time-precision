<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Durations;

use DigitalCraftsman\DateTimePrecision\Duration;
use DigitalCraftsman\DateTimePrecision\Durations;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Durations::class)]
final class ConstructionTest extends TestCase
{
    #[Test]
    public function construction_works(): void
    {
        // -- Act
        $collection = new Durations([
            Duration::fromMinutes(15),
            Duration::fromMinutes(30),
            Duration::fromMinutes(45),
        ]);

        // -- Assert
        self::assertCount(3, $collection->durations);
    }

    #[Test]
    public function construction_works_without_elements(): void
    {
        // -- Act
        $collection = new Durations([]);

        // -- Assert
        self::assertSame([], $collection->durations);
    }

    #[Test]
    #[DataProvider('dataProvider')]
    public function construction_fails_with_duplicates(
        string $order,
    ): void {
        // -- Arrange
        $elements = match ($order) {
            'duplicate after first' => [
                Duration::fromMinutes(15),
                Duration::fromMinutes(15),
            ],
            'duplicate of first after other' => [
                Duration::fromMinutes(15),
                Duration::fromMinutes(30),
                Duration::fromMinutes(15),
            ],
            'duplicate of second at the end' => [
                Duration::fromMinutes(45),
                Duration::fromMinutes(30),
                Duration::fromMinutes(30),
            ],
        };

        // -- Assert
        $this->expectException(\DigitalCraftsman\DateTimePrecision\Exception\CollectionContainsDuplicates::class);

        // -- Act
        new Durations($elements);
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
