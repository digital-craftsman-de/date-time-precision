<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\Date;

use DigitalCraftsman\DateTimeParts\Date;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\Date */
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
