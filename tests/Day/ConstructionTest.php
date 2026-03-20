<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Day;

use DigitalCraftsman\DateTimePrecision\Day;
use DigitalCraftsman\DateTimePrecision\Exception\InvalidDay;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Day
 */
final class ConstructionTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::fromDateTime
     */
    public function from_date_time_works(
        Day $expectedResult,
        \DateTimeImmutable $dateTime,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, Day::fromDateTime($dateTime));
    }

    /**
     * @return array<string, array{
     *   0: Day,
     *   1: \DateTimeImmutable,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'first day of month' => [
                new Day(1),
                new \DateTimeImmutable('2022-10-01 22:15:00'),
            ],
            'middle of month' => [
                new Day(15),
                new \DateTimeImmutable('2022-10-15 10:00:00'),
            ],
            'last day of month' => [
                new Day(31),
                new \DateTimeImmutable('2022-10-31 23:59:59'),
            ],
        ];
    }

    /**
     * @test
     *
     * @covers ::__construct
     *
     * @doesNotPerformAssertions
     */
    public function construction_works(): void
    {
        // -- Act & Assert
        new Day(1);
        new Day(15);
        new Day(31);
    }

    /**
     * @test
     *
     * @covers ::__construct
     */
    public function construction_fails_with_day_too_low(): void
    {
        // -- Assert
        $this->expectException(InvalidDay::class);

        // -- Act
        new Day(0);
    }

    /**
     * @test
     *
     * @covers ::__construct
     */
    public function construction_fails_with_day_too_high(): void
    {
        // -- Assert
        $this->expectException(InvalidDay::class);

        // -- Act
        new Day(32);
    }

    /**
     * @test
     *
     * @covers ::__construct
     */
    public function construction_fails_with_negative_day(): void
    {
        // -- Assert
        $this->expectException(InvalidDay::class);

        // -- Act
        new Day(-1);
    }
}
