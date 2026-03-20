<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Weekdays;

use DigitalCraftsman\DateTimePrecision\Weekday;
use DigitalCraftsman\DateTimePrecision\Weekdays;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Weekdays::class)]
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
        new Weekdays([
            Weekday::MONDAY,
            Weekday::TUESDAY,
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
        new Weekdays([
            Weekday::MONDAY,
            Weekday::MONDAY,
            Weekday::TUESDAY,
        ]);
    }
}
