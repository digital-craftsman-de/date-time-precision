<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Times;

use DigitalCraftsman\DateTimePrecision\Time;
use DigitalCraftsman\DateTimePrecision\Times;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Times::class)]
final class FirstAndLastTest extends TestCase
{
    #[Test]
    public function first_and_last_works(): void
    {
        // -- Arrange
        $collection = new Times([
            new Time(10, 0, 0),
            new Time(11, 0, 0),
            new Time(12, 0, 0),
        ]);

        // -- Act & Assert
        self::assertEquals(new Time(10, 0, 0), $collection->first());
        self::assertEquals(new Time(12, 0, 0), $collection->last());
    }

    #[Test]
    public function first_and_last_works_without_elements(): void
    {
        // -- Arrange
        $collection = new Times([]);

        // -- Act & Assert
        self::assertNull($collection->first());
        self::assertNull($collection->last());
    }
}
