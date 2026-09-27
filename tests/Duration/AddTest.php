<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Duration;

use DigitalCraftsman\DateTimePrecision\Duration;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Duration::class)]
final class AddTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function add_works(
        Duration $expectedResult,
        Duration $duration,
        Duration $durationToAdd,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $duration->add($durationToAdd));
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
            'add minutes to hours' => [
                Duration::fromMinutes(90),
                Duration::fromHours(1),
                Duration::fromMinutes(30),
            ],
            'add zero' => [
                Duration::fromHours(1),
                Duration::fromHours(1),
                Duration::zero(),
            ],
        ];
    }
}
