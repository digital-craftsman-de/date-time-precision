<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * A half-open range of moments. The start is part of the range, the end isn't. Therefore, a range ending at 12:00 doesn't overlap with a
 * range starting at 12:00.
 *
 * @psalm-type NormalizedMomentRange = array{
 *     start: string,
 *     end: string,
 * }
 */
final readonly class MomentRange implements ArrayNormalizable, NullableArrayDenormalizable
{
    use NullableArrayDenormalizableTrait;

    // -- Construction

    /**
     * @throws Exception\MomentRangeStartIsNotBeforeEnd
     */
    public function __construct(
        public Moment $start,
        public Moment $end,
    ) {
        if ($start->isNotBefore($end)) {
            throw new Exception\MomentRangeStartIsNotBeforeEnd();
        }
    }

    // -- Array normalizable

    /**
     * @param NormalizedMomentRange $data
     */
    #[\Override]
    public static function denormalize(array $data): self
    {
        return new self(
            Moment::denormalize($data['start']),
            Moment::denormalize($data['end']),
        );
    }

    /**
     * @return NormalizedMomentRange
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
     * By default, the start is included and the end isn't (like the range itself).
     */
    public function contains(
        Moment $moment,
        PeriodLimit $periodLimit = PeriodLimit::INCLUDING_START,
    ): bool {
        return $moment->isBetween($this->start, $this->end, $periodLimit);
    }

    /**
     * By default, the start is included and the end isn't (like the range itself).
     */
    public function notContains(
        Moment $moment,
        PeriodLimit $periodLimit = PeriodLimit::INCLUDING_START,
    ): bool {
        return !$this->contains($moment, $periodLimit);
    }

    public function containsRange(self $momentRange): bool
    {
        return $momentRange->start->isAfterOrEqualTo($this->start)
            && $momentRange->end->isBeforeOrEqualTo($this->end);
    }

    public function notContainsRange(self $momentRange): bool
    {
        return !$this->containsRange($momentRange);
    }

    public function overlaps(self $momentRange): bool
    {
        return $this->start->isBefore($momentRange->end)
            && $momentRange->start->isBefore($this->end);
    }

    /**
     * Returns the range both ranges have in common or null when they don't overlap.
     */
    public function intersection(self $momentRange): ?self
    {
        if (!$this->overlaps($momentRange)) {
            return null;
        }

        return new self(
            $this->start->isAfter($momentRange->start)
                ? $this->start
                : $momentRange->start,
            $this->end->isBefore($momentRange->end)
                ? $this->end
                : $momentRange->end,
        );
    }

    public function overlapDuration(self $momentRange): Duration
    {
        return $this->intersection($momentRange)?->duration()
            ?? Duration::zero();
    }

    public function duration(): Duration
    {
        return $this->start->durationUntil($this->end);
    }

    public function isEqualTo(self $momentRange): bool
    {
        return $this->start->isEqualTo($momentRange->start)
            && $this->end->isEqualTo($momentRange->end);
    }

    public function isNotEqualTo(self $momentRange): bool
    {
        return !$this->isEqualTo($momentRange);
    }

    /**
     * Returns all moments from the start in steps of the given duration. The end isn't included.
     *
     * @throws Exception\DurationIsZero
     */
    public function moments(Duration $step): Moments
    {
        if ($step->isZero()) {
            throw new Exception\DurationIsZero();
        }

        $moments = [];
        $moment = $this->start;
        while ($moment->isBefore($this->end)) {
            $moments[] = $moment;
            $moment = $moment->add($step);
        }

        return new Moments($moments);
    }

    /**
     * Returns all dates in the given timezone which are touched by the range. As the end isn't part of the range, a range ending at
     * midnight in the timezone doesn't include the following date.
     */
    public function dateRangeInTimeZone(\DateTimeZone $timeZone): DateRange
    {
        return new DateRange(
            $this->start->dateInTimeZone($timeZone),
            $this->end
                ->subtract(Duration::fromMicroseconds(1))
                ->dateInTimeZone($timeZone),
        );
    }

    /**
     * @throws Exception\MomentRangeIsLongerThanADay when the end is later than the same time on the following day in the timezone
     * @throws Exception\TimeRangeStartIsEqualToEnd  when the range is exactly one day, but doesn't start at midnight in the timezone
     */
    public function timeRangeInTimeZone(\DateTimeZone $timeZone): TimeRange
    {
        if ($this->end->isAfter($this->start->addInTimeZone(CalendarPeriod::days(1), $timeZone))) {
            throw new Exception\MomentRangeIsLongerThanADay();
        }

        return new TimeRange(
            $this->start->timeInTimeZone($timeZone),
            $this->end->timeInTimeZone($timeZone),
        );
    }

    // -- Mutations

    public function shiftForward(Duration $duration): self
    {
        return new self(
            $this->start->add($duration),
            $this->end->add($duration),
        );
    }

    public function shiftBackward(Duration $duration): self
    {
        return new self(
            $this->start->subtract($duration),
            $this->end->subtract($duration),
        );
    }

    /**
     * Start and end are moved separately in the calendar of the timezone with the native behaviour of \DateTimeImmutable.
     *
     * @throws Exception\MomentRangeStartIsNotBeforeEnd when a native overflow moves the start to or after the end
     */
    public function shiftForwardInTimeZone(CalendarPeriod $calendarPeriod, \DateTimeZone $timeZone): self
    {
        return new self(
            $this->start->addInTimeZone($calendarPeriod, $timeZone),
            $this->end->addInTimeZone($calendarPeriod, $timeZone),
        );
    }

    /**
     * Start and end are moved separately in the calendar of the timezone with the native behaviour of \DateTimeImmutable.
     *
     * @throws Exception\MomentRangeStartIsNotBeforeEnd when a native overflow moves the start to or after the end
     */
    public function shiftBackwardInTimeZone(CalendarPeriod $calendarPeriod, \DateTimeZone $timeZone): self
    {
        return new self(
            $this->start->subtractInTimeZone($calendarPeriod, $timeZone),
            $this->end->subtractInTimeZone($calendarPeriod, $timeZone),
        );
    }
}
