<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\Time */
final class TimeTest extends TestCase
{
    /**
     * @test
     *
     * @doesNotPerformAssertions
     *
     * @covers ::__construct
     */
    public function construct_works(): void
    {
        // -- Arrange & Act
        new Time(22, 15, 0);
    }

    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::__construct
     */
    public function construct_does_not_works(
        int $hour,
        int $minute,
        int $second,
        int $millisecond,
    ): void {
        // -- Assert
        $this->expectException(\InvalidArgumentException::class);

        // -- Act
        new Time($hour, $minute, $second, $millisecond);
    }

    /**
     * @return array<string, array{
     *   0: int,
     *   1: int,
     *   2: int,
     *   3: int,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'invalid hour' => [
                25,
                15,
                30,
                0,
            ],
            'invalid minute' => [
                22,
                77,
                30,
                0,
            ],
            'invalid second' => [
                22,
                15,
                80,
                0,
            ],
            'invalid millisecond' => [
                22,
                15,
                30,
                9999999999999,
            ],
        ];
    }

    /**
     * @test
     *
     * @covers ::fromDateTime
     */
    public function from_date_time_works(): void
    {
        // -- Arrange
        $expectedTime = new Time(22, 15, 0);
        $dateTime = DateTime::fromString('2022-10-08 22:15:00');

        // -- Act
        $time = Time::fromDateTime($dateTime->dateTime);

        // -- Assert
        self::assertTrue($expectedTime->isEqualTo($time));
    }

    /**
     * @test
     *
     * @covers ::fromString
     */
    public function from_string_works(): void
    {
        // -- Arrange
        $expectedTime = new Time(22, 15, 0);

        // -- Act
        $time = Time::fromString('22:15:00');

        // -- Assert
        self::assertTrue($expectedTime->isEqualTo($time));
    }

    /**
     * @test
     *
     * @covers ::fromString
     */
    public function from_string_fails(): void
    {
        // -- Assert
        $this->expectException(\InvalidArgumentException::class);

        // -- Arrange & Act
        Time::fromString('22:77:00');
    }

    /**
     * @test
     *
     * @covers ::__toString
     */
    public function to_string_works(): void
    {
        // -- Arrange & Act
        $time = Time::fromString('15:00:00');

        // -- Assert
        self::assertEquals('15:00:00.000000', (string) $time);
    }
}
