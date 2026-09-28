<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Times;

use DigitalCraftsman\DateTimePrecision\Time;
use DigitalCraftsman\DateTimePrecision\Times;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Times::class)]
final class ContainsTest extends TestCase
{
    #[Test]
    public function contains_works(): void
    {
        // -- Arrange
        $collection = new Times([
            new Time(10, 0, 0),
            new Time(11, 0, 0),
        ]);

        // -- Act & Assert
        self::assertTrue($collection->contains(new Time(10, 0, 0)));
        self::assertTrue($collection->contains(new Time(11, 0, 0)));
        self::assertFalse($collection->contains(new Time(12, 0, 0)));
        self::assertFalse(new Times([])->contains(new Time(10, 0, 0)));
    }

    #[Test]
    public function not_contains_works(): void
    {
        // -- Arrange
        $collection = new Times([
            new Time(10, 0, 0),
            new Time(11, 0, 0),
        ]);

        // -- Act & Assert
        self::assertFalse($collection->notContains(new Time(10, 0, 0)));
        self::assertTrue($collection->notContains(new Time(12, 0, 0)));
    }
}
