<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

final readonly class CalendarWeek
{
    // -- Construction

    public function __construct(
        public int $week,
    ) {
        if ($week < 1
            || $week > 53
        ) {
            // TODO: Better exception
            throw new \InvalidArgumentException(sprintf('Value "%d" is not a valid week.', $week));
        }
    }

    public static function fromDateTime(\DateTimeImmutable $dateTime): self
    {
        return new self(
            (int) $dateTime->format('W'),
        );
    }

    // -- Accessors

    public function isEqualTo(self $month): bool
    {
        return $this->toDateTimeImmutable() == $month->toDateTimeImmutable();
    }

    public function isNotEqualTo(self $month): bool
    {
        return $this->toDateTimeImmutable() != $month->toDateTimeImmutable();
    }

    public function isBefore(self $month): bool
    {
        return $this->toDateTimeImmutable() < $month->toDateTimeImmutable();
    }

    public function isNotBefore(self $month): bool
    {
        return !($this->toDateTimeImmutable() < $month->toDateTimeImmutable());
    }

    public function isBeforeOrEqualTo(self $month): bool
    {
        return $this->toDateTimeImmutable() <= $month->toDateTimeImmutable();
    }

    public function isNotBeforeOrEqualTo(self $month): bool
    {
        return !($this->toDateTimeImmutable() <= $month->toDateTimeImmutable());
    }

    public function isAfter(self $month): bool
    {
        return $this->toDateTimeImmutable() > $month->toDateTimeImmutable();
    }

    public function isNotAfter(self $month): bool
    {
        return !($this->toDateTimeImmutable() > $month->toDateTimeImmutable());
    }

    public function isAfterOrEqualTo(self $month): bool
    {
        return $this->toDateTimeImmutable() >= $month->toDateTimeImmutable();
    }

    public function isNotAfterOrEqualTo(self $month): bool
    {
        return !($this->toDateTimeImmutable() >= $month->toDateTimeImmutable());
    }

    public function compareTo(self $month): int
    {
        return $this->toDateTimeImmutable() <=> $month->toDateTimeImmutable();
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
         * two place with part of it above and part below.
         */
        $period = new \DatePeriod($startDateTime, $interval, $endDateTime, \DatePeriod::EXCLUDE_START_DATE);

        $months = [];
        foreach ($period as $dateTime) {
            $months[] = self::fromDateTime($dateTime);
        }

        return $months;
    }

    // -- Mutations

    public function firstDay(): Date
    {
        $firstDayOfMonth = new \DateTimeImmutable(sprintf(
            'first day of %d-%d',
            $this->year->year,
            $this->week,
        ));

        return Date::fromDateTime($firstDayOfMonth);
    }

    public function lastDay(): Date
    {
        $lastDayOfMonth = new \DateTimeImmutable(sprintf(
            'last day of %d-%d',
            $this->year->year,
            $this->week,
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

        /** @psalm-suppress PossiblyFalseArgument */
        return self::fromDateTime($modifiedDateTime);
    }

    public function toMomentInTimeZone(\DateTimeZone $timeZone): Moment
    {
        return Moment::fromStringInTimeZone(
            sprintf(
                '%d-%d-01 00:00:00',
                $this->year->year,
                $this->week,
            ),
            $timeZone,
        );
    }

    public function modifyInTimeZone(string $modify, \DateTimeZone $timeZone): self
    {
        $dateTimeImmutable = new \DateTimeImmutable(
            sprintf(
                '%d-%d-01 00:00:00',
                $this->year->year,
                $this->week,
            ),
            $timeZone,
        );

        /** @psalm-suppress PossiblyFalseArgument */
        return self::fromDateTime($dateTimeImmutable->modify($modify));
    }

    private function toDateTimeImmutable(): \DateTimeImmutable
    {
        /** @psalm-suppress FalsableReturnStatement */
        return \DateTimeImmutable::createFromFormat(
            'W',
            (string) $this->week,
        );
    }
}
