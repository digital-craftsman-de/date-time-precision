<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Duration;

use DigitalCraftsman\DateTimePrecision\Duration;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Duration::class)]
final class DivideByTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function divide_by_works(
        float $expectedResult,
        Duration $duration,
        Duration $divisor,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $duration->divideBy($divisor));
    }

    /**
     * @return array<string, array{
     *   0: float,
     *   1: Duration,
     *   2: Duration,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'fits exactly' => [
                4.0,
                Duration::fromHours(1),
                Duration::fromMinutes(15),
            ],
            'fits partially' => [
                1.5,
                Duration::fromMinutes(45),
                Duration::fromMinutes(30),
            ],
            'zero divided' => [
                0.0,
                Duration::zero(),
                Duration::fromMinutes(30),
            ],
        ];
    }

    #[Test]
    public function divide_by_fails_with_zero(): void
    {
        // -- Assert
        $this->expectException(\DivisionByZeroError::class);

        // -- Act
        Duration::fromMinutes(30)->divideBy(Duration::zero());
    }
}
