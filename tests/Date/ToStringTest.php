<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\Date;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Date::class)]
final class ToStringTest extends TestCase
{
    /**
     * @test
     */
    public function to_string_works(): void
    {
        // -- Arrange & Act
        $date = Date::fromString('2022-10-08');

        // -- Assert
        self::assertEquals('2022-10-08', (string) $date);
    }
}
