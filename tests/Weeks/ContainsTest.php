<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Weeks;

use DigitalCraftsman\DateTimePrecision\Week;
use DigitalCraftsman\DateTimePrecision\Weeks;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Weeks::class)]
final class ContainsTest extends TestCase
{
    #[Test]
    public function contains_works(): void
    {
        // -- Arrange
        $collection = new Weeks([
            Week::fromString('2026-W01'),
            Week::fromString('2026-W02'),
        ]);

        // -- Act & Assert
        self::assertTrue($collection->contains(Week::fromString('2026-W01')));
        self::assertTrue($collection->contains(Week::fromString('2026-W02')));
        self::assertFalse($collection->contains(Week::fromString('2026-W03')));
        self::assertFalse(new Weeks([])->contains(Week::fromString('2026-W01')));
        self::assertFalse($collection->notContains(Week::fromString('2026-W01')));
        self::assertTrue($collection->notContains(Week::fromString('2026-W03')));
    }
}
