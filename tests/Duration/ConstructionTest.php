<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Duration;

use DigitalCraftsman\DateTimePrecision\Duration;
use DigitalCraftsman\DateTimePrecision\Exception\InvalidDuration;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Duration::class)]
#[CoversClass(InvalidDuration::class)]
final class ConstructionTest extends TestCase
{
    #[Test]
    public function construction_works(): void
    {
        // -- Act & Assert
        self::assertSame(0, Duration::zero()->microseconds);
        self::assertSame(0, new Duration(0)->microseconds);
        self::assertSame(5, new Duration(5)->microseconds);
    }

    /**
     * The factory methods are called in the test instead of the data provider, as data providers aren't part of the code coverage.
     *
     * @param \Closure(int): Duration $factory
     */
    #[Test]
    #[DataProvider('dataProvider')]
    public function construction_through_factory_works(
        int $expectedMicroseconds,
        \Closure $factory,
    ): void {
        // -- Act
        $duration = $factory(5);

        // -- Assert
        self::assertSame($expectedMicroseconds, $duration->microseconds);
    }

    /**
     * @return array<string, array{
     *   0: int,
     *   1: \Closure(int): Duration,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'from microseconds' => [
                5,
                Duration::fromMicroseconds(...),
            ],
            'from milliseconds' => [
                5_000,
                Duration::fromMilliseconds(...),
            ],
            'from seconds' => [
                5_000_000,
                Duration::fromSeconds(...),
            ],
            'from minutes' => [
                300_000_000,
                Duration::fromMinutes(...),
            ],
            'from hours' => [
                18_000_000_000,
                Duration::fromHours(...),
            ],
        ];
    }

    #[Test]
    public function construction_fails_with_negative_microseconds(): void
    {
        // -- Assert
        $this->expectException(InvalidDuration::class);

        // -- Act
        new Duration(-1);
    }

    #[Test]
    public function construction_fails_with_negative_hours(): void
    {
        // -- Assert
        $this->expectException(InvalidDuration::class);

        // -- Act
        Duration::fromHours(-1);
    }
}
