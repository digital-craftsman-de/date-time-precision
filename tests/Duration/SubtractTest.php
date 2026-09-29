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
final class SubtractTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function subtract_works(
        Duration $expectedResult,
        Duration $duration,
        Duration $durationToSubtract,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $duration->subtract($durationToSubtract));
    }

    /**
     * @return array<string, array{
     *   0: Duration,
     *   1: Duration,
     *   2: Duration,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'subtract minutes from hours' => [
                Duration::fromMinutes(30),
                Duration::fromHours(1),
                Duration::fromMinutes(30),
            ],
            'subtract same duration' => [
                Duration::zero(),
                Duration::fromHours(1),
                Duration::fromMinutes(60),
            ],
        ];
    }

    #[Test]
    public function subtract_fails_when_result_would_be_negative(): void
    {
        // -- Assert
        $this->expectException(InvalidDuration::class);

        // -- Act
        Duration::fromMinutes(30)->subtract(Duration::fromHours(1));
    }
}
