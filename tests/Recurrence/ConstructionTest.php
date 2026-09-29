<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Recurrence;

use DigitalCraftsman\DateTimePrecision\Day;
use DigitalCraftsman\DateTimePrecision\Days;
use DigitalCraftsman\DateTimePrecision\Exception\InvalidRecurrence;
use DigitalCraftsman\DateTimePrecision\Recurrence;
use DigitalCraftsman\DateTimePrecision\RecurrenceFrequency;
use DigitalCraftsman\DateTimePrecision\Weekday;
use DigitalCraftsman\DateTimePrecision\Weekdays;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Recurrence::class)]
#[CoversClass(InvalidRecurrence::class)]
final class ConstructionTest extends TestCase
{
    #[Test]
    public function construction_works(): void
    {
        // -- Act
        $daily = Recurrence::daily();
        $weekly = Recurrence::weekly(new Weekdays([Weekday::FRIDAY, Weekday::MONDAY]));
        $monthly = Recurrence::monthly(new Days([new Day(15), new Day(1)]));

        // -- Assert
        self::assertSame(RecurrenceFrequency::DAILY, $daily->frequency);
        self::assertNull($daily->weekdays);
        self::assertNull($daily->days);
        self::assertSame(RecurrenceFrequency::WEEKLY, $weekly->frequency);
        self::assertSame(['MONDAY', 'FRIDAY'], $weekly->weekdays?->normalize());
        self::assertNull($weekly->days);
        self::assertSame(RecurrenceFrequency::MONTHLY, $monthly->frequency);
        self::assertNull($monthly->weekdays);
        self::assertSame([1, 15], $monthly->days?->normalize());
    }

    #[Test]
    #[DataProvider('invalidDataProvider')]
    public function construction_fails_with_invalid_combination(
        RecurrenceFrequency $frequency,
        ?string $weekdays,
        ?string $days,
    ): void {
        // -- Assert
        $this->expectException(InvalidRecurrence::class);

        // -- Act
        new Recurrence(
            $frequency,
            match ($weekdays) {
                null => null,
                'empty' => new Weekdays([]),
                'monday' => new Weekdays([Weekday::MONDAY]),
            },
            match ($days) {
                null => null,
                'empty' => new Days([]),
                'first' => new Days([new Day(1)]),
            },
        );
    }

    /**
     * @return array<string, array{
     *   0: RecurrenceFrequency,
     *   1: ?string,
     *   2: ?string,
     * }>
     */
    public static function invalidDataProvider(): array
    {
        return [
            'daily with weekdays' => [RecurrenceFrequency::DAILY, 'monday', null],
            'daily with days' => [RecurrenceFrequency::DAILY, null, 'first'],
            'weekly without weekdays' => [RecurrenceFrequency::WEEKLY, null, null],
            'weekly with empty weekdays' => [RecurrenceFrequency::WEEKLY, 'empty', null],
            'weekly with days' => [RecurrenceFrequency::WEEKLY, 'monday', 'first'],
            'monthly without days' => [RecurrenceFrequency::MONTHLY, null, null],
            'monthly with empty days' => [RecurrenceFrequency::MONTHLY, null, 'empty'],
            'monthly with weekdays' => [RecurrenceFrequency::MONTHLY, 'monday', 'first'],
        ];
    }

    #[Test]
    public function normalization_works(): void
    {
        // -- Arrange
        $recurrence = Recurrence::weekly(new Weekdays([Weekday::FRIDAY, Weekday::MONDAY]));

        // -- Act
        $normalizedRecurrence = $recurrence->normalize();

        // -- Assert
        self::assertSame([
            'frequency' => 'WEEKLY',
            'weekdays' => ['MONDAY', 'FRIDAY'],
            'days' => null,
        ], $normalizedRecurrence);
        self::assertTrue($recurrence->isEqualTo(Recurrence::denormalize($normalizedRecurrence)));
        self::assertTrue(Recurrence::monthly(new Days([new Day(3)]))->isEqualTo(Recurrence::denormalize([
            'frequency' => 'MONTHLY',
            'weekdays' => null,
            'days' => [3],
        ])));
        self::assertNull(Recurrence::denormalizeWhenNotNull(null));
    }

    #[Test]
    public function is_equal_to_works(): void
    {
        // -- Arrange
        $recurrence = Recurrence::weekly(new Weekdays([Weekday::MONDAY, Weekday::FRIDAY]));

        // -- Act & Assert
        self::assertTrue($recurrence->isEqualTo(Recurrence::weekly(new Weekdays([Weekday::FRIDAY, Weekday::MONDAY]))));
        self::assertFalse($recurrence->isNotEqualTo(Recurrence::weekly(new Weekdays([Weekday::FRIDAY, Weekday::MONDAY]))));
        self::assertFalse($recurrence->isEqualTo(Recurrence::weekly(new Weekdays([Weekday::MONDAY]))));
        self::assertTrue($recurrence->isNotEqualTo(Recurrence::weekly(new Weekdays([Weekday::MONDAY]))));
        self::assertFalse(Recurrence::daily()->isEqualTo(Recurrence::monthly(new Days([new Day(1)]))));
    }
}
