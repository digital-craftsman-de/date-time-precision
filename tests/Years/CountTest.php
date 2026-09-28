<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Years;

use DigitalCraftsman\DateTimePrecision\Year;
use DigitalCraftsman\DateTimePrecision\Years;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Years::class)]
final class CountTest extends TestCase
{
    #[Test]
    public function count_and_iteration_works(): void
    {
        // -- Arrange
        $collection = new Years([
            new Year(2024),
            new Year(2025),
        ]);

        // -- Act & Assert
        self::assertCount(2, $collection);
        self::assertSame(2, $collection->count());
        self::assertEquals([
            new Year(2024),
            new Year(2025),
        ], iterator_to_array($collection));
        self::assertFalse($collection->isEmpty());
        self::assertTrue($collection->isNotEmpty());
    }

    #[Test]
    public function count_and_iteration_works_without_elements(): void
    {
        // -- Arrange
        $collection = new Years([]);

        // -- Act & Assert
        self::assertCount(0, $collection);
        self::assertSame([], iterator_to_array($collection));
        self::assertTrue($collection->isEmpty());
        self::assertFalse($collection->isNotEmpty());
    }
}
