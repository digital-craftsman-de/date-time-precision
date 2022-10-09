<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\ValueObject;

/** @psalm-immutable */
final class Month implements \Stringable
{
    private const MONTH_FORMAT = 'Y-m';

    // -- Construction

    public function __construct(
        public readonly Year $year,
        public readonly int $monthOfYear,
    ) {
    }

    public static function fromDateTime(\DateTimeImmutable $dateTime): self
    {
        /** @psalm-suppress PossiblyNullArrayAccess */
        [$year, $monthOfYear] = sscanf(
            $dateTime->format('Y-n'),
            '%d-%d',
        );

        /**
         * @psalm-suppress PossiblyNullArgument
         * @psalm-suppress PossiblyInvalidArgument
         */
        return new self(
            new Year(
                $year,
            ),
            $monthOfYear,
        );
    }

    public static function fromString(string $month): self
    {
        try {
            return self::fromDateTime(new \DateTimeImmutable($month));
        } catch (\Exception) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is not valid month format.', $month));
        }
    }

    // -- Stringable

    public function __toString()
    {
        return $this->format(self::MONTH_FORMAT);
    }

    // -- Accessors

    public function isEqualTo(self $month): bool
    {
        return $this->monthOfYear === $month->monthOfYear
            && $this->year->isEqualTo($month->year);
    }

    public function isBefore(self $month): bool
    {
        if ($this->year->isBefore($month->year)) {
            return true;
        }

        if ($this->year->isAfter($month->year)) {
            return false;
        }

        return $this->monthOfYear < $month->monthOfYear;
    }

    public function isBeforeOrEqualTo(self $month): bool
    {
        if ($this->year->isBefore($month->year)) {
            return true;
        }

        if ($this->year->isAfter($month->year)) {
            return false;
        }

        return $this->monthOfYear <= $month->monthOfYear;
    }

    public function isAfter(self $month): bool
    {
        if ($this->year->isAfter($month->year)) {
            return true;
        }

        if ($this->year->isBefore($month->year)) {
            return false;
        }

        return $this->monthOfYear > $month->monthOfYear;
    }

    public function isAfterOrEqualTo(self $month): bool
    {
        if ($this->year->isAfter($month->year)) {
            return true;
        }

        if ($this->year->isBefore($month->year)) {
            return false;
        }

        return $this->monthOfYear >= $month->monthOfYear;
    }

    /**
     * Returns all months until the given month. If the given month is before this month, the result will be an empty array.
     *
     * @return array<int, Month>
     */
    public function monthsUntil(
        self $month,
        PeriodLimit $periodLimit = PeriodLimit::INCLUDING_START_AND_END,
    ): array {
        $startDateTime = $periodLimit === PeriodLimit::INCLUDING_START_AND_END
            || $periodLimit === PeriodLimit::INCLUDING_START
            ? $this
                ->modify('- 1 month')
                ->toDateTimeImmutable()
            : $this->toDateTimeImmutable();

        $endDateTime = $periodLimit === PeriodLimit::INCLUDING_START_AND_END
            || $periodLimit === PeriodLimit::INCLUDING_END
            ? $month
                ->modify('+ 1 month')
                ->toDateTimeImmutable()
            : $month->toDateTimeImmutable();

        $interval = new \DateInterval('P1M');
        /**
         * The options here seem counter-intuitive, but are set in a way that this logic is only handled in one place (above) instead of
         * two place with part of it above and part below. With PHP 8.2 there is a nicer way with an additional flag.
         */
        $period = new \DatePeriod($startDateTime, $interval, $endDateTime, \DatePeriod::EXCLUDE_START_DATE);

        $months = [];
        foreach ($period as $date) {
            $months[] = self::fromDateTime($date);
        }

        return $months;
    }

    // -- Mutations

    public function firstDay(): Date
    {
        $firstDayOfMonth = new \DateTimeImmutable(sprintf(
            'first day of %d-%d',
            $this->year->year,
            $this->monthOfYear,
        ));

        return Date::fromDateTime($firstDayOfMonth);
    }

    public function lastDay(): Date
    {
        $lastDayOfMonth = new \DateTimeImmutable(sprintf(
            'first day of %d-%d',
            $this->year->year,
            $this->monthOfYear,
        ));

        return Date::fromDateTime($lastDayOfMonth);
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

        if ($modifiedDateTime === false) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is not valid modifier.', $modifier));
        }

        return self::fromDateTime($modifiedDateTime);
    }

    private function toDateTimeImmutable(): \DateTimeImmutable
    {
        return new \DateTimeImmutable(
            sprintf(
                '%d-%d-01 00:00:00',
                $this->year->year,
                $this->monthOfYear,
            ),
        );
    }
}
