<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\TimeRanges;

use DigitalCraftsman\DateTimePrecision\Time;
use DigitalCraftsman\DateTimePrecision\TimeRange;
use DigitalCraftsman\DateTimePrecision\TimeRanges;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(TimeRanges::class)]
final class ConstructionTest extends TestCase
{
    #[Test]
    public function construction_works(): void
    {
        // -- Act
        $collection = new TimeRanges([
            new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
            new TimeRange(Time::fromString('21:00:00'), Time::fromString('03:00:00')),
            new TimeRange(Time::fromString('00:00:00'), Time::fromString('00:00:00')),
        ]);

        // -- Assert
        self::assertCount(3, $collection->timeRanges);
    }

    #[Test]
    public function construction_works_without_elements(): void
    {
        // -- Act
        $collection = new TimeRanges([]);

        // -- Assert
        self::assertSame([], $collection->timeRanges);
    }

    #[Test]
    #[DataProvider('dataProvider')]
    public function construction_fails_with_duplicates(
        string $order,
    ): void {
        // -- Arrange
        $elements = match ($order) {
            'duplicate after first' => [
                new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
                new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
            ],
            'duplicate of first after other' => [
                new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
                new TimeRange(Time::fromString('21:00:00'), Time::fromString('03:00:00')),
                new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
            ],
            'duplicate of second at the end' => [
                new TimeRange(Time::fromString('00:00:00'), Time::fromString('00:00:00')),
                new TimeRange(Time::fromString('21:00:00'), Time::fromString('03:00:00')),
                new TimeRange(Time::fromString('21:00:00'), Time::fromString('03:00:00')),
            ],
        };

        // -- Assert
        $this->expectException(\DigitalCraftsman\DateTimePrecision\Exception\CollectionContainsDuplicates::class);

        // -- Act
        new TimeRanges($elements);
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

    #[Test]
    public function construction_works_with_same_start_or_end(): void
    {
        // -- Act
        $collection = new TimeRanges([
            new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00')),
            new TimeRange(Time::fromString('10:00:00'), Time::fromString('13:00:00')),
            new TimeRange(Time::fromString('10:00:00'), Time::fromString('12:00:00.000001')),
            new TimeRange(Time::fromString('11:00:00'), Time::fromString('12:00:00')),
            new TimeRange(Time::fromString('10:00:00.000001'), Time::fromString('12:00:00')),
        ]);

        // -- Assert
        self::assertCount(5, $collection);
    }
}
