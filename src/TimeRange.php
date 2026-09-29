<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * A half-open range of times of a day. The start is part of the range, the end isn't.
 *
 * - An end of 00:00 is the end of the day (24:00).
 * - The range may wrap around midnight (e.g. 21:00 until 03:00 ends on the following day).
 * - 00:00 until 00:00 is the full day.
 *
 * More strict rules (like not wrapping around midnight) can be enforced with the guard methods.
 *
 * @psalm-type NormalizedTimeRange = array{
 *     start: string,
 *     end: string,
 * }
 */
final readonly class TimeRange implements ArrayNormalizable, NullableArrayDenormalizable
{
    use NullableArrayDenormalizableTrait;

    private const int HOURS_IN_A_DAY = 24;

    // -- Construction

    /**
     * @throws Exception\TimeRangeStartIsEqualToEnd
     */
    public function __construct(
        public Time $start,
        public Time $end,
    ) {
        if ($start->isNotMidnight()
            && $start->isEqualTo($end)
        ) {
            throw new Exception\TimeRangeStartIsEqualToEnd();
        }
    }

    // -- Array normalizable

    /**
     * @param NormalizedTimeRange $data
     */
    #[\Override]
    public static function denormalize(array $data): self
    {
        return new self(
            Time::denormalize($data['start']),
            Time::denormalize($data['end']),
        );
    }

    /**
     * @return NormalizedTimeRange
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

    public function isFullDay(): bool
    {
        return $this->start->isMidnight()
            && $this->end->isMidnight();
    }

    public function endsAtMidnight(): bool
    {
        return $this->end->isMidnight();
    }

    /**
     * An end at midnight is the end of the day and therefore doesn't wrap around midnight.
     */
    public function wrapsAroundMidnight(): bool
    {
        return $this->end->isNotMidnight()
            && $this->end->isBefore($this->start);
    }

    public function duration(): Duration
    {
        if ($this->isFullDay()) {
            return Duration::fromHours(self::HOURS_IN_A_DAY);
        }

        return $this->start->durationUntil($this->end);
    }

    /**
     * By default, the start is included and the end isn't (like the range itself). In a full day, midnight is the start and the end at
     * the same time and is therefore only excluded with EXCLUDING_START_AND_END.
     */
    public function contains(
        Time $time,
        PeriodLimit $periodLimit = PeriodLimit::INCLUDING_START,
    ): bool {
        $offset = $this->start->durationUntil($time);

        if ($offset->isZero()) {
            return $this->isFullDay()
                ? $periodLimit !== PeriodLimit::EXCLUDING_START_AND_END
                : $periodLimit->includesStart();
        }

        return $periodLimit->includesEnd()
            ? $offset->isShorterThanOrEqualTo($this->duration())
            : $offset->isShorterThan($this->duration());
    }

    /**
     * By default, the start is included and the end isn't (like the range itself).
     */
    public function notContains(
        Time $time,
        PeriodLimit $periodLimit = PeriodLimit::INCLUDING_START,
    ): bool {
        return !$this->contains($time, $periodLimit);
    }

    public function containsRange(self $timeRange): bool
    {
        return $this->start
            ->durationUntil($timeRange->start)
            ->add($timeRange->duration())
            ->isShorterThanOrEqualTo($this->duration());
    }

    public function notContainsRange(self $timeRange): bool
    {
        return !$this->containsRange($timeRange);
    }

    public function overlaps(self $timeRange): bool
    {
        return $this->contains($timeRange->start)
            || $timeRange->contains($this->start);
    }

    /**
     * Whether the time is reached from the start in steps of the given duration within the range. The end is included as it's a valid end
     * for a step (e.g. 10:00 until 12:00 in steps of 30 minutes is aligned to 10:00, 10:30, ..., 12:00).
     *
     * @throws Exception\DurationIsZero
     */
    public function isAlignedTo(Time $time, Duration $step): bool
    {
        if ($step->isZero()) {
            throw new Exception\DurationIsZero();
        }

        $offset = $this->start->durationUntil($time);

        return $offset->isShorterThanOrEqualTo($this->duration())
            && $offset->microseconds % $step->microseconds === 0;
    }

    public function isEqualTo(self $timeRange): bool
    {
        return $this->start->isEqualTo($timeRange->start)
            && $this->end->isEqualTo($timeRange->end);
    }

    public function isNotEqualTo(self $timeRange): bool
    {
        return !$this->isEqualTo($timeRange);
    }

    // -- Guards

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\TimeRangeStartIsBefore
     */
    public function mustNotStartBefore(
        Time $time,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->start->isBefore($time)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\TimeRangeStartIsBefore();
        }
    }

    /**
     * An end at midnight (24:00) is still allowed.
     *
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\TimeRangeWrapsAroundMidnight
     */
    public function mustNotWrapAroundMidnight(
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->wrapsAroundMidnight()) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\TimeRangeWrapsAroundMidnight();
        }
    }
}
