<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\MomentRange;

use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\MomentRange;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(MomentRange::class)]
final class IsEqualToTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function is_equal_to_works(
        bool $expectedResult,
        string $start,
        string $end,
    ): void {
        // -- Arrange
        $momentRange = new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00'));
        $otherMomentRange = new MomentRange(Moment::fromString($start), Moment::fromString($end));

        // -- Act & Assert
        self::assertSame($expectedResult, $momentRange->isEqualTo($otherMomentRange));
        self::assertSame(!$expectedResult, $momentRange->isNotEqualTo($otherMomentRange));
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: string,
     *   2: string,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'same' => [true, '2026-01-01 10:00:00', '2026-01-01 12:00:00'],
            'different start' => [false, '2026-01-01 10:00:01', '2026-01-01 12:00:00'],
            'different end' => [false, '2026-01-01 10:00:00', '2026-01-01 12:00:01'],
        ];
    }
}
