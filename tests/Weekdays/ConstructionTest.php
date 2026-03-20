<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Weekdays;

use DigitalCraftsman\DateTimePrecision\Weekday;
use DigitalCraftsman\DateTimePrecision\Weekdays;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Weekdays::class)]
final class ConstructionTest extends TestCase
{
    #[Test]
    #[DoesNotPerformAssertions]
    public function construction_works(): void
    {
        // -- Act & Assert
        new Weekdays([
            Weekday::MONDAY,
            Weekday::TUESDAY,
        ]);
    }

    #[Test]
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
