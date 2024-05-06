<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Clock;

use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(FrozenClock::class)]
final class FrozenClockTest extends TestCase
{
    #[Test]
    public function freeze_works(): void
    {
        // -- Arrange
        $clock = new FrozenClock();
        $moment = Moment::fromStringInTimeZone('2024-05-06 08:00:00', new \DateTimeZone('Europe/Berlin'));

        // -- Act
        $clock->freeze($moment);

        // -- Assert
        self::assertSame($moment, $clock->now());
    }
}
