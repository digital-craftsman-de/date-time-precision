<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Doctrine\StringNormalizableTypeWithMaxLength;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableStringDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableStringDenormalizableTrait;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\StringNormalizable;

/**
 * A calendar week according to ISO 8601. A week starts on Monday and belongs to the year in which its Thursday is. Therefore, the year
 * of a week can differ from the year of its dates around new year (e.g. 29.12.2025 is part of the week 2026-W01).
 */
final readonly class Week implements \Stringable, StringNormalizable, NullableStringDenormalizable, StringNormalizableTypeWithMaxLength
{
    use NullableStringDenormalizableTrait;

    private const string WEEK_FORMAT = 'o-\WW';

    // -- Construction

    /**
     * @throws Exception\InvalidWeek
     */
    public function __construct(
        public Year $year,
        public int $week,
    ) {
        if ($week < 1
            || $week > self::numberOfWeeksInYear($year)
        ) {
            throw new Exception\InvalidWeek($year->year, $week);
        }
    }

    public static function fromDateTime(\DateTimeImmutable $dateTime): self
    {
        return new self(
            new Year((int) $dateTime->format('o')),
            (int) $dateTime->format('W'),
        );
    }

    /**
     * Expects the ISO 8601 format like 2026-W01.
     */
    public static function fromString(string $week): self
    {
        if (preg_match('/^(?<year>\d{4})-W(?<week>\d{2})$/', $week, $matches) !== 1) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is not valid week format.', $week));
        }

        return new self(
            new Year((int) $matches['year']),
            (int) $matches['week'],
        );
    }

    // -- Stringable

    #[\Override]
    public function __toString(): string
    {
        return $this->format(self::WEEK_FORMAT);
    }

    // -- String normalizable

    #[\Override]
    public static function denormalize(string $data): self
    {
        return self::fromString($data);
    }

    #[\Override]
    public function normalize(): string
    {
        return $this->format(self::WEEK_FORMAT);
    }

    // -- Accessors

    public function isEqualTo(self $week): bool
    {
        return $this->toDateTimeImmutable() == $week->toDateTimeImmutable();
    }

    public function isNotEqualTo(self $week): bool
    {
        return $this->toDateTimeImmutable() != $week->toDateTimeImmutable();
    }

    public function isBefore(self $week): bool
    {
        return $this->toDateTimeImmutable() < $week->toDateTimeImmutable();
    }

    public function isNotBefore(self $week): bool
    {
        return !($this->toDateTimeImmutable() < $week->toDateTimeImmutable());
    }

    public function isBeforeOrEqualTo(self $week): bool
    {
        return $this->toDateTimeImmutable() <= $week->toDateTimeImmutable();
    }

    public function isNotBeforeOrEqualTo(self $week): bool
    {
        return !($this->toDateTimeImmutable() <= $week->toDateTimeImmutable());
    }

    public function isAfter(self $week): bool
    {
        return $this->toDateTimeImmutable() > $week->toDateTimeImmutable();
    }

    public function isNotAfter(self $week): bool
    {
        return !($this->toDateTimeImmutable() > $week->toDateTimeImmutable());
    }

    public function isAfterOrEqualTo(self $week): bool
    {
        return $this->toDateTimeImmutable() >= $week->toDateTimeImmutable();
    }

    public function isNotAfterOrEqualTo(self $week): bool
    {
        return !($this->toDateTimeImmutable() >= $week->toDateTimeImmutable());
    }

    public function compareTo(self $week): int
    {
        return $this->toDateTimeImmutable() <=> $week->toDateTimeImmutable();
    }

    public function isBetween(
        self $start,
        self $end,
        PeriodLimit $periodLimit = PeriodLimit::INCLUDING_START_AND_END,
    ): bool {
        $isAfterStart = $periodLimit->includesStart()
            ? $this->isAfterOrEqualTo($start)
            : $this->isAfter($start);

        $isBeforeEnd = $periodLimit->includesEnd()
            ? $this->isBeforeOrEqualTo($end)
            : $this->isBefore($end);

        return $isAfterStart
            && $isBeforeEnd;
    }

    public function isNotBetween(
        self $start,
        self $end,
        PeriodLimit $periodLimit = PeriodLimit::INCLUDING_START_AND_END,
    ): bool {
        return !$this->isBetween($start, $end, $periodLimit);
    }

    /**
     * Returns the earliest of the given weeks.
     */
    public static function min(
        self $week,
        self ...$weeks,
    ): self {
        foreach ($weeks as $other) {
            if ($other->isBefore($week)) {
                $week = $other;
            }
        }

        return $week;
    }

    /**
     * Returns the latest of the given weeks.
     */
    public static function max(
        self $week,
        self ...$weeks,
    ): self {
        foreach ($weeks as $other) {
            if ($other->isAfter($week)) {
                $week = $other;
            }
        }

        return $week;
    }

    /**
     * Can be used as callable for sorting (e.g. usort($weeks, Week::compare(...))).
     */
    public static function compare(self $a, self $b): int
    {
        return $a->compareTo($b);
    }

    public function contains(Date $date): bool
    {
        return $date->week()->isEqualTo($this);
    }

    public function notContains(Date $date): bool
    {
        return !$this->contains($date);
    }

    public function dateRange(): DateRange
    {
        return new DateRange(
            $this->firstDay(),
            $this->lastDay(),
        );
    }

    /**
     * All dates from Monday until Sunday.
     */
    public function dates(): Dates
    {
        return $this->dateRange()->dates();
    }

    /**
     * Returns all weeks until the given week. If the given week is before this week, the result will be an empty collection.
     */
    public function weeksUntil(
        self $week,
        PeriodLimit $periodLimit = PeriodLimit::INCLUDING_START_AND_END,
    ): Weeks {
        $startDateTime = $periodLimit->includesStart()
            ? $this
                ->previous()
                ->toDateTimeImmutable()
            : $this->toDateTimeImmutable();

        $endDateTime = $periodLimit->includesEnd()
            ? $week
                ->next()
                ->toDateTimeImmutable()
            : $week->toDateTimeImmutable();

        $interval = new \DateInterval('P1W');
        /**
         * The options here seem counter-intuitive, but are set in a way that this logic is only handled in one place (above) instead of
         * two place with part of it above and part below.
         */
        $period = new \DatePeriod($startDateTime, $interval, $endDateTime, \DatePeriod::EXCLUDE_START_DATE);

        $weeks = [];
        foreach ($period as $dateTime) {
            $weeks[] = self::fromDateTime($dateTime);
        }

        return new Weeks($weeks);
    }

    /**
     * @throws Exception\WeekIsBefore when the given week is before this week
     */
    public function periodUntil(self $week): CalendarPeriod
    {
        if ($week->isBefore($this)) {
            throw new Exception\WeekIsBefore();
        }

        return CalendarPeriod::fromDateInterval(
            $this->toDateTimeImmutable()->diff($week->toDateTimeImmutable()),
            CalendarUnit::WEEK,
        );
    }

    // -- Mutations

    /**
     * @throws Exception\CalendarUnitIsNotSupported when the unit is not a week
     */
    public function add(CalendarPeriod $calendarPeriod): self
    {
        self::mustSupportCalendarUnit($calendarPeriod->unit);

        return self::fromDateTime($this->toDateTimeImmutable()->modify(sprintf('+%s', $calendarPeriod->modifier())));
    }

    /**
     * @throws Exception\CalendarUnitIsNotSupported when the unit is not a week
     */
    public function subtract(CalendarPeriod $calendarPeriod): self
    {
        self::mustSupportCalendarUnit($calendarPeriod->unit);

        return self::fromDateTime($this->toDateTimeImmutable()->modify(sprintf('-%s', $calendarPeriod->modifier())));
    }

    public function next(): self
    {
        return $this->add(CalendarPeriod::weeks(1));
    }

    public function previous(): self
    {
        return $this->subtract(CalendarPeriod::weeks(1));
    }

    /**
     * The Monday of the week.
     */
    public function firstDay(): Date
    {
        return Date::fromDateTime($this->toDateTimeImmutable());
    }

    /**
     * The Sunday of the week.
     */
    public function lastDay(): Date
    {
        return Date::fromDateTime($this->toDateTimeImmutable()->modify('+6 days'));
    }

    public function format(string $format): string
    {
        return $this
            ->toDateTimeImmutable()
            ->format($format);
    }

    /**
     * The start of the Monday in the timezone.
     */
    public function toMomentInTimeZone(\DateTimeZone $timeZone): Moment
    {
        return $this
            ->firstDay()
            ->toMomentInTimeZone($timeZone);
    }

    /**
     * From the start of the Monday in the timezone until the start of the next Monday. The end isn't part of the range.
     */
    public function toMomentRangeInTimeZone(\DateTimeZone $timeZone): MomentRange
    {
        return new MomentRange(
            $this->toMomentInTimeZone($timeZone),
            $this->next()->toMomentInTimeZone($timeZone),
        );
    }

    /**
     * @throws Exception\CalendarUnitIsNotSupported
     */
    private static function mustSupportCalendarUnit(CalendarUnit $calendarUnit): void
    {
        if ($calendarUnit !== CalendarUnit::WEEK) {
            throw new Exception\CalendarUnitIsNotSupported($calendarUnit, self::class);
        }
    }

    /**
     * Years have 53 weeks when the 28th of December is in week 53.
     */
    private static function numberOfWeeksInYear(Year $year): int
    {
        return (int) new \DateTimeImmutable(sprintf('%d-12-28', $year->year), new \DateTimeZone('UTC'))->format('W');
    }

    /**
     * The Monday of the week at midnight in UTC.
     */
    private function toDateTimeImmutable(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('2000-01-01 00:00:00', new \DateTimeZone('UTC'))
            ->setISODate($this->year->year, $this->week);
    }

    /**
     * @codeCoverageIgnore
     */
    #[\Override]
    public static function maxLength(): int
    {
        return 8;
    }
}
