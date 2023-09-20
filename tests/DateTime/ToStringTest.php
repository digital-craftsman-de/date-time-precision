<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\DateTime;

use DigitalCraftsman\DateTimeParts\DateTime;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\DateTime */
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
        $dateTime = DateTime::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin'));

        // -- Assert
        self::assertEquals('2022-10-08T13:00:00+00:00', (string) $dateTime);
    }
}