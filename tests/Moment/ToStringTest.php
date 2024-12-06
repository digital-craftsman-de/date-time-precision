<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Moment
 */
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
        $dateTime = Moment::fromStringInTimeZone('2022-10-08 15:00:00.000000', new \DateTimeZone('Europe/Berlin'));

        // -- Assert
        self::assertEquals('2022-10-08 13:00:00.000000', (string) $dateTime);
    }
}
