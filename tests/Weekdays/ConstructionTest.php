<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Weekdays;

use DigitalCraftsman\DateTimePrecision\Weekday;
use DigitalCraftsman\DateTimePrecision\Weekdays;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Weekdays */
final class ConstructionTest extends TestCase
{
    /**
     * @test
     *
     * @covers ::__construct
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
     *
     * @covers ::__construct
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
