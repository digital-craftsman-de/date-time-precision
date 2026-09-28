<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * A rule on which dates something recurs: every day, on specific weekdays or on specific days of the month. A day of the month which
 * doesn't exist in a month (e.g. the 31st) is skipped in that month.
 *
 * The recurrence neither contains a time nor a start or end. Those are part of the domain in which it's used.
 *
 * @psalm-import-type NormalizedWeekdays from Weekdays
 * @psalm-import-type NormalizedDays from Days
 *
 * @psalm-type NormalizedRecurrence = array{
 *     frequency: string,
 *     weekdays: NormalizedWeekdays|null,
 *     days: NormalizedDays|null,
 * }
 */
final readonly class Recurrence implements ArrayNormalizable, NullableArrayDenormalizable
{
    use NullableArrayDenormalizableTrait;

    /**
     * Set for a weekly recurrence, sorted from Monday to Sunday.
     */
    public ?Weekdays $weekdays;

    /**
     * Set for a monthly recurrence, sorted ascending.
     */
    public ?Days $days;

    // -- Construction

    /**
     * @throws Exception\InvalidRecurrence
     */
    public function __construct(
        public RecurrenceFrequency $frequency,
        ?Weekdays $weekdays,
        ?Days $days,
    ) {
        match ($frequency) {
            RecurrenceFrequency::DAILY => $weekdays !== null || $days !== null
                ? throw new Exception\InvalidRecurrence('A daily recurrence must neither have weekdays nor days.')
                : null,
            RecurrenceFrequency::WEEKLY => $weekdays === null || $weekdays->isEmpty() || $days !== null
                ? throw new Exception\InvalidRecurrence('A weekly recurrence must have weekdays and no days.')
                : null,
            RecurrenceFrequency::MONTHLY => $days === null || $days->isEmpty() || $weekdays !== null
                ? throw new Exception\InvalidRecurrence('A monthly recurrence must have days and no weekdays.')
                : null,
        };

        $this->weekdays = $weekdays?->sort();
        $this->days = $days?->sort();
    }

    public static function daily(): self
    {
        return new self(RecurrenceFrequency::DAILY, null, null);
    }

    public static function weekly(Weekdays $weekdays): self
    {
        return new self(RecurrenceFrequency::WEEKLY, $weekdays, null);
    }

    public static function monthly(Days $days): self
    {
        return new self(RecurrenceFrequency::MONTHLY, null, $days);
    }

    // -- Array normalizable

    /**
     * @param NormalizedRecurrence $data
     */
    #[\Override]
    public static function denormalize(array $data): self
    {
        return new self(
            RecurrenceFrequency::denormalize($data['frequency']),
            Weekdays::denormalizeWhenNotNull($data['weekdays']),
            Days::denormalizeWhenNotNull($data['days']),
        );
    }

    /**
     * @return NormalizedRecurrence
     */
    #[\Override]
    public function normalize(): array
    {
        return [
            'frequency' => $this->frequency->normalize(),
            'weekdays' => $this->weekdays?->normalize(),
            'days' => $this->days?->normalize(),
        ];
    }

    // -- Accessors

    public function isEqualTo(self $recurrence): bool
    {
        return $this->normalize() === $recurrence->normalize();
    }

    public function isNotEqualTo(self $recurrence): bool
    {
        return $this->normalize() !== $recurrence->normalize();
    }

    /**
     * The weekdays of a weekly and the days of a monthly recurrence are guaranteed through the constructor.
     *
     * @psalm-suppress PossiblyNullReference
     */
    public function occursOn(Date $date): bool
    {
        return match ($this->frequency) {
            RecurrenceFrequency::DAILY => true,
            RecurrenceFrequency::WEEKLY => $this->weekdays->contains($date->weekday()),
            RecurrenceFrequency::MONTHLY => $this->days->contains($date->day),
        };
    }

    public function doesNotOccurOn(Date $date): bool
    {
        return !$this->occursOn($date);
    }

    /**
     * The next date on which the recurrence occurs. The given date itself isn't included.
     */
    public function nextOccurrenceAfter(Date $date): Date
    {
        do {
            $date = $date->next();
        } while ($this->doesNotOccurOn($date));

        return $date;
    }

    /**
     * The given date itself is returned when the recurrence occurs on it.
     */
    public function previousOccurrenceOnOrBefore(Date $date): Date
    {
        while ($this->doesNotOccurOn($date)) {
            $date = $date->previous();
        }

        return $date;
    }

    public function occurrencesBetween(
        Date $start,
        Date $end,
        PeriodLimit $periodLimit = PeriodLimit::INCLUDING_START_AND_END,
    ): Dates {
        return $start
            ->datesUntil($end, $periodLimit)
            ->filter($this->occursOn(...));
    }

    /**
     * The next moment after the given one on which the recurrence occurs at the given time in the timezone. This might be today when
     * the recurrence occurs today and the time is still ahead.
     */
    public function nextOccurrenceAtTimeInTimeZone(
        Time $time,
        Moment $after,
        \DateTimeZone $timeZone,
    ): Moment {
        $date = $after->dateInTimeZone($timeZone);

        if ($this->occursOn($date)) {
            $occurrence = $date->atTimeInTimeZone($time, $timeZone);
            if ($occurrence->isAfter($after)) {
                return $occurrence;
            }
        }

        return $this
            ->nextOccurrenceAfter($date)
            ->atTimeInTimeZone($time, $timeZone);
    }

    // -- Guards

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\DateIsNotAnOccurrence
     */
    public function mustOccurOn(
        Date $date,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->doesNotOccurOn($date)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\DateIsNotAnOccurrence();
        }
    }
}
