<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Time;

use DigitalCraftsman\DateTimePrecision\Time;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * Microseconds below 100000 were previously interpreted as fractions of a second (5 microseconds as 0.5 seconds).
 */
#[CoversClass(Time::class)]
final class MicrosecondTest extends TestCase
{
    #[Test]
    public function small_microseconds_are_kept(): void
    {
        // -- Arrange
        $time = new Time(12, 0, 0, 5);

        // -- Act & Assert
        self::assertSame('12:00:00.000005', $time->format('H:i:s.u'));
        self::assertTrue($time->isBefore(new Time(12, 0, 0, 500_000)));
        self::assertEquals($time, $time->modify('+0 seconds'));
    }
}
