<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Times;

use DigitalCraftsman\DateTimePrecision\Time;
use DigitalCraftsman\DateTimePrecision\Times;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Times::class)]
final class ConstructionTest extends TestCase
{
    #[Test]
    public function construction_works(): void
    {
        // -- Act
        $collection = new Times([
            new Time(10, 0, 0),
            new Time(11, 0, 0),
            new Time(12, 0, 0),
        ]);

        // -- Assert
        self::assertCount(3, $collection->times);
    }

    #[Test]
    public function construction_works_without_elements(): void
    {
        // -- Act
        $collection = new Times([]);

        // -- Assert
        self::assertSame([], $collection->times);
    }

    #[Test]
    #[DataProvider('dataProvider')]
    public function construction_fails_with_duplicates(
        string $order,
    ): void {
        // -- Arrange
        $elements = match ($order) {
            'duplicate after first' => [
                new Time(10, 0, 0),
                new Time(10, 0, 0),
            ],
            'duplicate of first after other' => [
                new Time(10, 0, 0),
                new Time(11, 0, 0),
                new Time(10, 0, 0),
            ],
            'duplicate of second at the end' => [
                new Time(12, 0, 0),
                new Time(11, 0, 0),
                new Time(11, 0, 0),
            ],
        };

        // -- Assert
        $this->expectException(\InvalidArgumentException::class);

        // -- Act
        new Times($elements);
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

    /**
     * Uniqueness is based on the full precision of the times. As the normalization of a time doesn't contain microseconds, such a collection
     * can't be denormalized again.
     */
    #[Test]
    public function construction_works_with_times_differing_only_in_microseconds(): void
    {
        // -- Act
        $collection = new Times([
            new Time(10, 0, 0, 1),
            new Time(10, 0, 0, 2),
        ]);

        // -- Assert
        self::assertCount(2, $collection->times);
    }
}
