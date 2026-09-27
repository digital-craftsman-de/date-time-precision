<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * A closed range of dates. Start and end are both part of the range, so a range with the same start and end contains exactly one date.
 *
 * @psalm-type NormalizedDateRange = array{
 *     start: string,
 *     end: string,
 * }
 */
final readonly class DateRange implements ArrayNormalizable, NullableArrayDenormalizable
{
    use NullableArrayDenormalizableTrait;

    // -- Construction

    /**
     * @throws Exception\DateRangeStartIsAfterEnd
     */
    public function __construct(
        public Date $start,
        public Date $end,
    ) {
        if ($start->isAfter($end)) {
            throw new Exception\DateRangeStartIsAfterEnd();
        }
    }

    // -- Array normalizable

    /**
     * @param NormalizedDateRange $data
     */
    #[\Override]
    public static function denormalize(array $data): self
    {
        return new self(
            Date::denormalize($data['start']),
            Date::denormalize($data['end']),
        );
    }

    /**
     * @return NormalizedDateRange
     */
    #[\Override]
    public function normalize(): array
    {
        return [
            'start' => $this->start->normalize(),
            'end' => $this->end->normalize(),
        ];
    }

    // -- Accessors

    /**
     * Start and end are included by default.
     */
    public function contains(
        Date $date,
        PeriodLimit $periodLimit = PeriodLimit::INCLUDING_START_AND_END,
    ): bool {
        return $date->isBetween($this->start, $this->end, $periodLimit);
    }

    /**
     * Start and end are included by default.
     */
    public function notContains(
        Date $date,
        PeriodLimit $periodLimit = PeriodLimit::INCLUDING_START_AND_END,
    ): bool {
        return !$this->contains($date, $periodLimit);
    }

    public function containsRange(self $dateRange): bool
    {
        return $dateRange->start->isAfterOrEqualTo($this->start)
            && $dateRange->end->isBeforeOrEqualTo($this->end);
    }

    public function notContainsRange(self $dateRange): bool
    {
        return !$this->containsRange($dateRange);
    }

    public function overlaps(self $dateRange): bool
    {
        return $this->start->isBeforeOrEqualTo($dateRange->end)
            && $dateRange->start->isBeforeOrEqualTo($this->end);
    }

    public function isEqualTo(self $dateRange): bool
    {
        return $this->start->isEqualTo($dateRange->start)
            && $this->end->isEqualTo($dateRange->end);
    }

    public function isNotEqualTo(self $dateRange): bool
    {
        return !$this->isEqualTo($dateRange);
    }

    /**
     * @return array<int, Date>
     */
    public function dates(PeriodLimit $periodLimit = PeriodLimit::INCLUDING_START_AND_END): array
    {
        return $this->start->datesUntil($this->end, $periodLimit);
    }

    /**
     * Start and end are included (e.g. 01.01. until 03.01. are 3 days).
     */
    public function numberOfDays(): int
    {
        return $this->start->periodUntil($this->end, CalendarUnit::DAY)->amount + 1;
    }

    // -- Mutations

    /**
     * Start and end are moved separately with the native behaviour of \DateTimeImmutable.
     *
     * @throws Exception\DateRangeStartIsAfterEnd when a native overflow moves the start after the end (e.g. 31.01. until 01.02. + 1 month)
     */
    public function shiftForward(CalendarPeriod $calendarPeriod): self
    {
        return new self(
            $this->start->add($calendarPeriod),
            $this->end->add($calendarPeriod),
        );
    }

    /**
     * Start and end are moved separately with the native behaviour of \DateTimeImmutable.
     *
     * @throws Exception\DateRangeStartIsAfterEnd when a native overflow moves the start after the end
     */
    public function shiftBackward(CalendarPeriod $calendarPeriod): self
    {
        return new self(
            $this->start->subtract($calendarPeriod),
            $this->end->subtract($calendarPeriod),
        );
    }
}
