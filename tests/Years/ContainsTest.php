<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Years;

use DigitalCraftsman\DateTimePrecision\Year;
use DigitalCraftsman\DateTimePrecision\Years;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Years::class)]
final class ContainsTest extends TestCase
{
    #[Test]
    public function contains_works(): void
    {
        // -- Arrange
        $collection = new Years([
            new Year(2024),
            new Year(2025),
        ]);

        // -- Act & Assert
        self::assertTrue($collection->contains(new Year(2024)));
        self::assertTrue($collection->contains(new Year(2025)));
        self::assertFalse($collection->contains(new Year(2026)));
        self::assertFalse(new Years([])->contains(new Year(2024)));
    }

    #[Test]
    public function not_contains_works(): void
    {
        // -- Arrange
        $collection = new Years([
            new Year(2024),
            new Year(2025),
        ]);

        // -- Act & Assert
        self::assertFalse($collection->notContains(new Year(2024)));
        self::assertTrue($collection->notContains(new Year(2026)));
    }
}
