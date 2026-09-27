<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\MomentRange;

use DigitalCraftsman\DateTimePrecision\Duration;
use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\MomentRange;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(MomentRange::class)]
final class OverlapsTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function overlaps_works(
        bool $expectedResult,
        ?string $expectedIntersectionStart,
        ?string $expectedIntersectionEnd,
        int $expectedOverlapInMinutes,
        string $start,
        string $end,
    ): void {
        // -- Arrange
        $momentRange = new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00'));
        $otherMomentRange = new MomentRange(Moment::fromString($start), Moment::fromString($end));

        // -- Act
        $intersection = $momentRange->intersection($otherMomentRange);

        // -- Assert
        self::assertSame($expectedResult, $momentRange->overlaps($otherMomentRange));
        self::assertSame($expectedResult, $otherMomentRange->overlaps($momentRange));
        self::assertEquals(Duration::fromMinutes($expectedOverlapInMinutes), $momentRange->overlapDuration($otherMomentRange));
        self::assertEquals(Duration::fromMinutes($expectedOverlapInMinutes), $otherMomentRange->overlapDuration($momentRange));

        if ($expectedIntersectionStart === null
            || $expectedIntersectionEnd === null
        ) {
            self::assertNull($intersection);
        } else {
            self::assertNotNull($intersection);
            self::assertTrue(new MomentRange(
                Moment::fromString($expectedIntersectionStart),
                Moment::fromString($expectedIntersectionEnd),
            )->isEqualTo($intersection));
        }
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: ?string,
     *   2: ?string,
     *   3: int,
     *   4: string,
     *   5: string,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'ends before start' => [
                false,
                null,
                null,
                0,
                '2026-01-01 08:00:00',
                '2026-01-01 09:00:00',
            ],
            'ends at start' => [
                false,
                null,
                null,
                0,
                '2026-01-01 08:00:00',
                '2026-01-01 10:00:00',
            ],
            'overlaps start' => [
                true,
                '2026-01-01 10:00:00',
                '2026-01-01 10:30:00',
                30,
                '2026-01-01 09:00:00',
                '2026-01-01 10:30:00',
            ],
            'within' => [
                true,
                '2026-01-01 10:30:00',
                '2026-01-01 11:00:00',
                30,
                '2026-01-01 10:30:00',
                '2026-01-01 11:00:00',
            ],
            'overlaps end' => [
                true,
                '2026-01-01 11:15:00',
                '2026-01-01 12:00:00',
                45,
                '2026-01-01 11:15:00',
                '2026-01-01 13:00:00',
            ],
            'starts at end' => [
                false,
                null,
                null,
                0,
                '2026-01-01 12:00:00',
                '2026-01-01 13:00:00',
            ],
            'surrounds' => [
                true,
                '2026-01-01 10:00:00',
                '2026-01-01 12:00:00',
                120,
                '2026-01-01 09:00:00',
                '2026-01-01 13:00:00',
            ],
        ];
    }
}
