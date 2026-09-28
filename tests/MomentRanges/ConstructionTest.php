<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\MomentRanges;

use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\MomentRange;
use DigitalCraftsman\DateTimePrecision\MomentRanges;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(MomentRanges::class)]
final class ConstructionTest extends TestCase
{
    #[Test]
    public function construction_works(): void
    {
        // -- Act
        $collection = new MomentRanges([
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00')),
            new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 13:00:00')),
            new MomentRange(Moment::fromString('2026-01-01 14:00:00'), Moment::fromString('2026-01-01 16:00:00')),
        ]);

        // -- Assert
        self::assertCount(3, $collection->momentRanges);
    }

    #[Test]
    public function construction_works_without_elements(): void
    {
        // -- Act
        $collection = new MomentRanges([]);

        // -- Assert
        self::assertSame([], $collection->momentRanges);
    }

    #[Test]
    #[DataProvider('dataProvider')]
    public function construction_fails_with_duplicates(
        string $order,
    ): void {
        // -- Arrange
        $elements = match ($order) {
            'duplicate after first' => [
                new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00')),
                new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00')),
            ],
            'duplicate of first after other' => [
                new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00')),
                new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 13:00:00')),
                new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 12:00:00')),
            ],
            'duplicate of second at the end' => [
                new MomentRange(Moment::fromString('2026-01-01 14:00:00'), Moment::fromString('2026-01-01 16:00:00')),
                new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 13:00:00')),
                new MomentRange(Moment::fromString('2026-01-01 10:00:00'), Moment::fromString('2026-01-01 13:00:00')),
            ],
        };

        // -- Assert
        $this->expectException(\InvalidArgumentException::class);

        // -- Act
        new MomentRanges($elements);
    }

    /**
     * @return array<string, array{
     *   0: string,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'duplicate after first' => ['duplicate after first'],
            'duplicate of first after other' => ['duplicate of first after other'],
            'duplicate of second at the end' => ['duplicate of second at the end'],
        ];
    }
}
