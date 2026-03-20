<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Time;

use DigitalCraftsman\DateTimePrecision\Time;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Time::class)]
final class ToStringTest extends TestCase
{
    /**
     * @test
     */
    public function to_string_works(): void
    {
        // -- Arrange & Act
        $time = Time::fromString('15:00:00');

        // -- Assert
        self::assertEquals('15:00:00', (string) $time);
    }
}
