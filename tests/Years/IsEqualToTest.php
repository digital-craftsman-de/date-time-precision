<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Years;

use DigitalCraftsman\DateTimePrecision\Year;
use DigitalCraftsman\DateTimePrecision\Years;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Years::class)]
final class IsEqualToTest extends TestCase
{
    #[Test]
    public function is_equal_to_works(): void
    {
        // -- Arrange
        $collection = new Years([
            new Year(2024),
            new Year(2025),
        ]);

        // -- Act & Assert
        self::assertTrue($collection->isEqualTo(new Years([
            new Year(2024),
            new Year(2025),
        ])));
        self::assertTrue($collection->isEqualTo(new Years([
            new Year(2025),
            new Year(2024),
        ])));
        self::assertFalse($collection->isEqualTo(new Years([
            new Year(2024),
        ])));
        self::assertFalse(new Years([
            new Year(2024),
        ])->isEqualTo($collection));
        self::assertFalse($collection->isEqualTo(new Years([
            new Year(2024),
            new Year(2026),
        ])));
        self::assertTrue(new Years([])->isEqualTo(new Years([])));
    }

    #[Test]
    public function is_not_equal_to_works(): void
    {
        // -- Arrange
        $collection = new Years([
            new Year(2024),
            new Year(2025),
        ]);

        // -- Act & Assert
        self::assertFalse($collection->isNotEqualTo(new Years([
            new Year(2025),
            new Year(2024),
        ])));
        self::assertTrue($collection->isNotEqualTo(new Years([
            new Year(2024),
            new Year(2026),
        ])));
    }
}
