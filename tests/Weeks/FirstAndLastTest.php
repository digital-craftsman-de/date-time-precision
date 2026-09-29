<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Weeks;

use DigitalCraftsman\DateTimePrecision\Week;
use DigitalCraftsman\DateTimePrecision\Weeks;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Weeks::class)]
final class FirstAndLastTest extends TestCase
{
    #[Test]
    public function first_and_last_works(): void
    {
        // -- Arrange
        $collection = new Weeks([
            Week::fromString('2026-W01'),
            Week::fromString('2026-W02'),
            Week::fromString('2026-W03'),
        ]);

        // -- Act & Assert
        self::assertEquals(Week::fromString('2026-W01'), $collection->first());
        self::assertEquals(Week::fromString('2026-W03'), $collection->last());
    }

    #[Test]
    public function first_and_last_works_without_elements(): void
    {
        // -- Arrange
        $collection = new Weeks([]);

        // -- Act & Assert
        self::assertNull($collection->first());
        self::assertNull($collection->last());
    }
}
