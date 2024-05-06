<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Clock;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * Only very little that's possible to test here, so we do what's possible.
 */
#[CoversClass(SystemClock::class)]
final class SystemClockTest extends TestCase
{
    #[Test]
    public function now_works(): void
    {
        // -- Arrange
        $clock = new SystemClock();

        // -- Act
        $moment = $clock->now();

        // -- Assert
        self::assertEquals($moment->dateTime->getTimezone(), new \DateTimeZone('UTC'));
    }
}
