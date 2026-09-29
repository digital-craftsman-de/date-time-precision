<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\IntNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableIntDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableIntDenormalizableTrait;

final readonly class Year implements IntNormalizable, NullableIntDenormalizable
{
    use NullableIntDenormalizableTrait;

    // -- Construction

    public function __construct(
        public int $year,
    ) {
    }

    public static function fromDateTime(\DateTimeImmutable $dateTime): self
    {
        $year = (int) $dateTime->format('Y');

        return new self($year);
    }

    /** @param string $year Has to be date format `Y` */
    public static function fromString(string $year): self
    {
        $dateTime = \DateTimeImmutable::createFromFormat('Y', $year);
        if ($dateTime === false) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is not valid year format.', $year));
        }

        return self::fromDateTime($dateTime);
    }

    // Int normalizable

    #[\Override]
    public static function denormalize(int $data): self
    {
        return new self($data);
    }

    #[\Override]
    public function normalize(): int
    {
        return $this->year;
    }

    // -- Accessors

    public function isEqualTo(self $year): bool
    {
        return $this->year === $year->year;
    }

    public function isNotEqualTo(self $year): bool
    {
        return $this->year !== $year->year;
    }

    public function isBefore(self $year): bool
    {
        return $this->year < $year->year;
    }

    public function isNotBefore(self $year): bool
    {
        return !($this->year < $year->year);
    }

    public function isBeforeOrEqualTo(self $year): bool
    {
        return $this->year <= $year->year;
    }

    public function isNotBeforeOrEqualTo(self $year): bool
    {
        return !($this->year <= $year->year);
    }

    public function isAfter(self $year): bool
    {
        return $this->year > $year->year;
    }

    public function isNotAfter(self $year): bool
    {
        return !($this->year > $year->year);
    }

    public function isAfterOrEqualTo(self $year): bool
    {
        return $this->year >= $year->year;
    }

    public function isNotAfterOrEqualTo(self $year): bool
    {
        return !($this->year >= $year->year);
    }

    public function compareTo(self $year): int
    {
        return $this->year <=> $year->year;
    }

    /**
     * Returns the earliest of the given years.
     */
    public static function min(
        self $year,
        self ...$years,
    ): self {
        foreach ($years as $other) {
            if ($other->isBefore($year)) {
                $year = $other;
            }
        }

        return $year;
    }

    /**
     * Returns the latest of the given years.
     */
    public static function max(
        self $year,
        self ...$years,
    ): self {
        foreach ($years as $other) {
            if ($other->isAfter($year)) {
                $year = $other;
            }
        }

        return $year;
    }

    /**
     * Can be used as callable for sorting (e.g. usort($years, Year::compare(...))).
     */
    public static function compare(self $a, self $b): int
    {
        return $a->compareTo($b);
    }

    /**
     * Returns all years until the given year. If the given year is before this year, the result will be an empty collection.
     */
    public function yearsUntil(
        self $year,
        PeriodLimit $periodLimit = PeriodLimit::INCLUDING_START_AND_END,
    ): Years {
        $startDateTime = $periodLimit === PeriodLimit::INCLUDING_START_AND_END
        || $periodLimit === PeriodLimit::INCLUDING_START
            ? $this
                ->modify('- 1 year')
                ->toDateTimeImmutable()
            : $this->toDateTimeImmutable();

        $endDateTime = $periodLimit === PeriodLimit::INCLUDING_START_AND_END
        || $periodLimit === PeriodLimit::INCLUDING_END
            ? $year
                ->modify('+ 1 year')
                ->toDateTimeImmutable()
            : $year->toDateTimeImmutable();

        $interval = new \DateInterval('P1Y');
        /**
         * The options here seem counter-intuitive, but are set in a way that this logic is only handled in one place (above) instead of
         * two place with part of it above and part below.
         */
        $period = new \DatePeriod($startDateTime, $interval, $endDateTime, \DatePeriod::EXCLUDE_START_DATE);

        $years = [];
        foreach ($period as $dateTime) {
            $years[] = self::fromDateTime($dateTime);
        }

        return new Years($years);
    }

    /**
     * @throws Exception\YearIsBefore when the given year is before this year
     */
    public function periodUntil(self $year): CalendarPeriod
    {
        if ($year->isBefore($this)) {
            throw new Exception\YearIsBefore();
        }

        return CalendarPeriod::fromDateInterval(
            $this->toDateTimeImmutable()->diff($year->toDateTimeImmutable()),
            CalendarUnit::YEAR,
        );
    }

    // -- Mutations

    /**
     * @throws Exception\CalendarUnitIsNotSupported when the unit is not a year
     */
    public function add(CalendarPeriod $calendarPeriod): self
    {
        self::mustSupportCalendarUnit($calendarPeriod->unit);

        return $this->modify(sprintf('+%s', $calendarPeriod->modifier()));
    }

    /**
     * @throws Exception\CalendarUnitIsNotSupported when the unit is not a year
     */
    public function subtract(CalendarPeriod $calendarPeriod): self
    {
        self::mustSupportCalendarUnit($calendarPeriod->unit);

        return $this->modify(sprintf('-%s', $calendarPeriod->modifier()));
    }

    public function next(): self
    {
        return $this->add(CalendarPeriod::years(1));
    }

    public function previous(): self
    {
        return $this->subtract(CalendarPeriod::years(1));
    }

    public function format(string $format): string
    {
        return $this
            ->toDateTimeImmutable()
            ->format($format);
    }

    public function modify(string $modifier): self
    {
        $modifiedDateTime = $this->toDateTimeImmutable()
            ->modify($modifier);

        /** @psalm-suppress PossiblyFalseArgument */
        return self::fromDateTime($modifiedDateTime);
    }

    public function toMomentInTimeZone(\DateTimeZone $timeZone): Moment
    {
        return Moment::fromStringInTimeZone(
            sprintf(
                '%d-01-01 00:00:00',
                $this->year,
            ),
            $timeZone,
        );
    }

    /**
     * From the start in the timezone until the start of the next one. The end isn't part of the range.
     */
    public function toMomentRangeInTimeZone(\DateTimeZone $timeZone): MomentRange
    {
        return new MomentRange(
            $this->toMomentInTimeZone($timeZone),
            $this->next()->toMomentInTimeZone($timeZone),
        );
    }

    /**
     * @deprecated A year has no time and therefore the timezone has no effect. Use add, subtract or modify instead.
     */
    public function modifyInTimeZone(string $modify, \DateTimeZone $timeZone): self
    {
        $dateTimeImmutable = new \DateTimeImmutable(
            sprintf(
                '%d-01-01 00:00:00',
                $this->year,
            ),
            $timeZone,
        );

        /** @psalm-suppress PossiblyFalseArgument */
        return self::fromDateTime($dateTimeImmutable->modify($modify));
    }

    /**
     * @throws Exception\CalendarUnitIsNotSupported
     */
    private static function mustSupportCalendarUnit(CalendarUnit $calendarUnit): void
    {
        if ($calendarUnit !== CalendarUnit::YEAR) {
            throw new Exception\CalendarUnitIsNotSupported($calendarUnit, self::class);
        }
    }

    private function toDateTimeImmutable(): \DateTimeImmutable
    {
        return new \DateTimeImmutable(
            sprintf(
                '%d-01-01 00:00:00',
                $this->year,
            ),
        );
    }
}
