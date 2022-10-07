<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\ValueObject;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\ValueObject\DateTime */
final class DateTimeTest extends TestCase
{
    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::fromDateTime
     */
    public function construction_with_date_time_works(): void
    {
        // -- Assert
        $this->expectNotToPerformAssertions();

        // -- Arrange & Act
        DateTime::fromDateTime(new \DateTimeImmutable('now'));
    }

    /**
     * @test
     *
     * @covers ::toUTC
     * @covers ::timezone
     */
    public function to_utc_works(): void
    {
        // -- Arrange
        $dateTime = new DateTime(new \DateTimeImmutable(
            '2022-10-07 14:39:24',
            new \DateTimeZone('Europe/Berlin'),
        ));

        // -- Act
        $dateTimeInUTC = $dateTime->toUTC();

        // -- Assert
        self::assertEquals(
            $dateTimeInUTC->timezone(),
            new \DateTimeZone('UTC'),
        );
        self::assertTrue(
            $dateTimeInUTC->time()->isEqualTo(Time::fromString('12:39:24')),
        );
    }
}
