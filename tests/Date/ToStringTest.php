<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\Date;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Date */
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
        $date = Date::fromString('2022-10-08');

        // -- Assert
        self::assertEquals('2022-10-08', (string) $date);
    }
}
