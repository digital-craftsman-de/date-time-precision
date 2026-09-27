<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Duration;

use DigitalCraftsman\DateTimePrecision\Duration;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Duration::class)]
final class CompareTest extends TestCase
{
    /**
     * @param array{
     *   isEqualTo: bool,
     *   isLongerThan: bool,
     *   isLongerThanOrEqualTo: bool,
     *   isShorterThan: bool,
     *   isShorterThanOrEqualTo: bool,
     *   compareTo: int,
     * } $expectedResult
     */
    #[Test]
    #[DataProvider('dataProvider')]
    public function comparison_works(
        array $expectedResult,
        Duration $duration,
        Duration $comparator,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult['isEqualTo'], $duration->isEqualTo($comparator));
        self::assertSame(!$expectedResult['isEqualTo'], $duration->isNotEqualTo($comparator));
        self::assertSame($expectedResult['isLongerThan'], $duration->isLongerThan($comparator));
        self::assertSame($expectedResult['isLongerThanOrEqualTo'], $duration->isLongerThanOrEqualTo($comparator));
        self::assertSame($expectedResult['isShorterThan'], $duration->isShorterThan($comparator));
        self::assertSame($expectedResult['isShorterThanOrEqualTo'], $duration->isShorterThanOrEqualTo($comparator));
        self::assertSame($expectedResult['compareTo'], $duration->compareTo($comparator));
    }

    /**
     * @return array<string, array{
     *   0: array{
     *     isEqualTo: bool,
     *     isLongerThan: bool,
     *     isLongerThanOrEqualTo: bool,
     *     isShorterThan: bool,
     *     isShorterThanOrEqualTo: bool,
     *     compareTo: int,
     *   },
     *   1: Duration,
     *   2: Duration,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'shorter by one microsecond' => [
                [
                    'isEqualTo' => false,
                    'isLongerThan' => false,
                    'isLongerThanOrEqualTo' => false,
                    'isShorterThan' => true,
                    'isShorterThanOrEqualTo' => true,
                    'compareTo' => -1,
                ],
                Duration::fromMicroseconds(3_599_999_999),
                Duration::fromHours(1),
            ],
            'equal with different construction' => [
                [
                    'isEqualTo' => true,
                    'isLongerThan' => false,
                    'isLongerThanOrEqualTo' => true,
                    'isShorterThan' => false,
                    'isShorterThanOrEqualTo' => true,
                    'compareTo' => 0,
                ],
                Duration::fromMinutes(60),
                Duration::fromHours(1),
            ],
            'longer by one microsecond' => [
                [
                    'isEqualTo' => false,
                    'isLongerThan' => true,
                    'isLongerThanOrEqualTo' => true,
                    'isShorterThan' => false,
                    'isShorterThanOrEqualTo' => false,
                    'compareTo' => 1,
                ],
                Duration::fromMicroseconds(3_600_000_001),
                Duration::fromHours(1),
            ],
        ];
    }
}
