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
final class MultiplyTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function multiply_works(
        Duration $expectedResult,
        Duration $duration,
        int $factor,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $duration->multiply($factor));
    }

    /**
     * @return array<string, array{
     *   0: Duration,
     *   1: Duration,
     *   2: int,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'multiply by three' => [
                Duration::fromMinutes(45),
                Duration::fromMinutes(15),
                3,
            ],
            'multiply by zero' => [
                Duration::zero(),
                Duration::fromMinutes(15),
                0,
            ],
        ];
    }

    #[Test]
    public function multiply_fails_with_negative_factor(): void
    {
        // -- Assert
        $this->expectException(InvalidDuration::class);

        // -- Act
        Duration::fromMinutes(15)->multiply(-1);
    }
}
