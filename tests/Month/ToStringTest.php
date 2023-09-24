<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Month;

use DigitalCraftsman\DateTimePrecision\Month;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Month */
final class ToStringTest extends TestCase
{
    /**
     * @test
     *
     * @covers ::__toString
     */
    public function to_string_works(): void
    {
        // -- Arrange & Act
        $month = Month::fromString('2022-10');

        // -- Assert
        self::assertEquals('2022-10', (string) $month);
    }
}
