<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\Week;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Moment::class)]
final class WeekTest extends TestCase
{
    #[Test]
    public function week_works(): void
    {
        // -- Arrange
        $moment = Moment::fromString('2026-03-08 23:30:00');

        // -- Act & Assert
        self::assertEquals(Week::fromString('2026-W10'), $moment->week());
        self::assertEquals(Week::fromString('2026-W11'), $moment->weekInTimeZone(new \DateTimeZone('Europe/Berlin')));
    }
}
