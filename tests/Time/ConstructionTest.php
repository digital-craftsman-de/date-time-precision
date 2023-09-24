<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\Time;

use DigitalCraftsman\DateTimeParts\DateTime;
use DigitalCraftsman\DateTimeParts\Time;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\Time */
final class ConstructionTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProviderConstructWorks
     *
     * @doesNotPerformAssertions
     *
     * @covers ::__construct
     */
    public function construct_works(
        int $hour,
        int $minute,
        int $second,
        int $millisecond,
    ): void {
        // -- Arrange & Act
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
    public function dataProviderConstructWorks(): array
    {
        return [
            'upper border of hour' => [
                23,
                15,
                30,
                0,
            ],
            'upper border of minute' => [
                22,
                59,
                30,
                0,
            ],
            'upper border of second' => [
                22,
                15,
                59,
                0,
            ],
            'upper border of millisecond' => [
                22,
                15,
                30,
                999999,
            ],
            'lower border of hour' => [
                0,
                15,
                30,
                0,
            ],
            'lower border of minute' => [
                22,
                0,
                30,
                0,
            ],
            'lower border of second' => [
                22,
                15,
                0,
                0,
            ],
            'lower border of millisecond' => [
                22,
                15,
                30,
                0,
            ],
        ];
    }

    /**
     * @test
     *
     * @dataProvider dataProviderConstructDoesNotWork
     *
     * @covers ::__construct
     */
    public function construct_does_not_work(
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
    public function dataProviderConstructDoesNotWork(): array
    {
        return [
            'hour to high' => [
                24,
                15,
                30,
                0,
            ],
            'minute to high' => [
                22,
                60,
                30,
                0,
            ],
            'second to high' => [
                22,
                15,
                60,
                0,
            ],
            'millisecond to high' => [
                22,
                15,
                30,
                1000000,
            ],
            'hour to low' => [
                -1,
                15,
                30,
                0,
            ],
            'minute to low' => [
                22,
                -1,
                30,
                0,
            ],
            'second to low' => [
                22,
                15,
                -1,
                0,
            ],
            'millisecond to low' => [
                22,
                15,
                30,
                -1,
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
}
