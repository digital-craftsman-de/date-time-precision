<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Duration;

use DigitalCraftsman\DateTimePrecision\Duration;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Duration::class)]
final class IsZeroTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function is_zero_works(
        bool $expectedResult,
        Duration $duration,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $duration->isZero());
        self::assertSame(!$expectedResult, $duration->isNotZero());
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: Duration,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'zero' => [
                true,
                Duration::zero(),
            ],
            'one microsecond' => [
                false,
                Duration::fromMicroseconds(1),
            ],
        ];
    }
}
