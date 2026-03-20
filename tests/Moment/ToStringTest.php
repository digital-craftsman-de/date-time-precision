<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Moment::class)]
final class ToStringTest extends TestCase
{
    /**
     * @test
     */
    public function to_string_works(): void
    {
        // -- Arrange & Act
        $dateTime = Moment::fromStringInTimeZone('2022-10-08 15:00:00.000000', new \DateTimeZone('Europe/Berlin'));

        // -- Assert
        self::assertEquals('2022-10-08T13:00:00.000000+00:00', (string) $dateTime);
    }
}
