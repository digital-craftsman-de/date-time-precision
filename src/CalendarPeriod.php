<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * A movement in the calendar (e.g. 1 day or 3 months). As days and months don't have a fixed length, it's applied with the native
 * calculation of \DateTimeImmutable and therefore also follows its behaviour for overflows (e.g. 31.01. + 1 month = 03.03.). For elapsed
 * time use Duration.
 *
 * @psalm-type NormalizedCalendarPeriod = array{
 *     amount: int,
 *     unit: string,
 * }
 */
final readonly class CalendarPeriod implements ArrayNormalizable, NullableArrayDenormalizable
{
    use NullableArrayDenormalizableTrait;

    private const int MONTHS_IN_A_QUARTER = 3;
    private const int MONTHS_IN_A_YEAR = 12;
    private const int DAYS_IN_A_WEEK = 7;

    // -- Construction

    public function __construct(
        public int $amount,
        public CalendarUnit $unit,
    ) {
        if ($amount < 0) {
            throw new Exception\InvalidCalendarPeriod($amount);
        }
    }

    public static function days(int $amount): self
    {
        return new self($amount, CalendarUnit::DAY);
    }

    public static function weeks(int $amount): self
    {
        return new self($amount, CalendarUnit::WEEK);
    }

    public static function months(int $amount): self
    {
        return new self($amount, CalendarUnit::MONTH);
    }

    public static function quarters(int $amount): self
    {
        return new self($amount, CalendarUnit::QUARTER);
    }

    public static function years(int $amount): self
    {
        return new self($amount, CalendarUnit::YEAR);
    }

    /**
     * Only full units are counted (e.g. 31.01. until 01.03. is 0 months and 29 days).
     *
     * @internal
     *
     * @throws \InvalidArgumentException when the interval wasn't created through a diff
     */
    public static function fromDateInterval(
        \DateInterval $interval,
        CalendarUnit $unit,
    ): self {
        $days = $interval->days;
        if ($days === false) {
            throw new \InvalidArgumentException('Only intervals created through a diff are supported.');
        }

        $months = $interval->y * self::MONTHS_IN_A_YEAR + $interval->m;

        return new self(
            match ($unit) {
                CalendarUnit::DAY => $days,
                CalendarUnit::WEEK => intdiv($days, self::DAYS_IN_A_WEEK),
                CalendarUnit::MONTH => $months,
                CalendarUnit::QUARTER => intdiv($months, self::MONTHS_IN_A_QUARTER),
                CalendarUnit::YEAR => $interval->y,
            },
            $unit,
        );
    }

    // -- Array normalizable

    /**
     * @param NormalizedCalendarPeriod $data
     */
    #[\Override]
    public static function denormalize(array $data): self
    {
        return new self(
            $data['amount'],
            CalendarUnit::denormalize($data['unit']),
        );
    }

    /**
     * @return NormalizedCalendarPeriod
     */
    #[\Override]
    public function normalize(): array
    {
        return [
            'amount' => $this->amount,
            'unit' => $this->unit->normalize(),
        ];
    }

    // -- Accessors

    /**
     * Periods are only equal when amount and unit are equal. 7 days are not equal to 1 week.
     */
    public function isEqualTo(self $calendarPeriod): bool
    {
        return $this->amount === $calendarPeriod->amount
            && $this->unit === $calendarPeriod->unit;
    }

    public function isNotEqualTo(self $calendarPeriod): bool
    {
        return $this->amount !== $calendarPeriod->amount
            || $this->unit !== $calendarPeriod->unit;
    }

    /**
     * Relative format for \DateTimeImmutable::modify without sign (e.g. "3 months").
     *
     * @internal
     */
    public function modifier(): string
    {
        return match ($this->unit) {
            CalendarUnit::DAY => sprintf('%d days', $this->amount),
            CalendarUnit::WEEK => sprintf('%d weeks', $this->amount),
            CalendarUnit::MONTH => sprintf('%d months', $this->amount),
            CalendarUnit::QUARTER => sprintf('%d months', $this->amount * self::MONTHS_IN_A_QUARTER),
            CalendarUnit::YEAR => sprintf('%d years', $this->amount),
        };
    }

    // -- Mutations

    /**
     * @throws Exception\InvalidCalendarPeriod when the factor is negative
     */
    public function multiply(int $factor): self
    {
        return new self($this->amount * $factor, $this->unit);
    }
}
