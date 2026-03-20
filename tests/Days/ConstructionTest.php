<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Days;

use DigitalCraftsman\DateTimePrecision\Day;
use DigitalCraftsman\DateTimePrecision\Days;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Days::class)]
final class ConstructionTest extends TestCase
{
    /**
     * @test
     *
     * @doesNotPerformAssertions
     */
    public function construction_works(): void
    {
        // -- Act & Assert
        new Days([
            new Day(1),
            new Day(15),
        ]);
    }

    /**
     * @test
     */
    public function construction_fails(): void
    {
        // -- Assert
        $this->expectException(\InvalidArgumentException::class);

        // -- Act
        new Days([
            new Day(1),
            new Day(1),
            new Day(15),
        ]);
    }
}
