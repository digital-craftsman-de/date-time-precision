<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

final readonly class Date implements \Stringable
{
    private const DATE_FORMAT = 'Y-m-d';

    // -- Construction

    public function __construct(
        public Month $month,
        public int $day,
    ) {
    }

    public static function fromDateTime(\DateTimeImmutable $dateTime): self
    {
        /**
         * @psalm-suppress PossiblyNullArrayAccess
         * @psalm-suppress PossiblyUndefinedArrayOffset
         */
        [$year, $month, $day] = sscanf(
            $dateTime->format(self::DATE_FORMAT),
            '%d-%d-%d',
        );

        /**
         * @psalm-suppress PossiblyNullArgument
         * @psalm-suppress PossiblyInvalidArgument
         */
        return new self(
            new Month(
                new Year($year),
                $month,
            ),
            $day,
        );
    }

    public static function fromString(string $date): self
    {
        try {
            return self::fromDateTime(new \DateTimeImmutable($date));
        } catch (\Exception) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is not valid date format.', $date));
        }
    }

    // -- Stringable

    public function __toString(): string
    {
        return $this->format(self::DATE_FORMAT);
    }

    // -- Accessors

    public function isEqualTo(self $date): bool
    {
        return $this->toDateTimeImmutable() == $date->toDateTimeImmutable();
    }

    public function isNotEqualTo(self $date): bool
    {
        return $this->toDateTimeImmutable() != $date->toDateTimeImmutable();
    }

    public function isBefore(self $date): bool
    {
        return $this->toDateTimeImmutable() < $date->toDateTimeImmutable();
    }

    public function isNotBefore(self $date): bool
    {
        return !($this->toDateTimeImmutable() < $date->toDateTimeImmutable());
    }

    public function isBeforeOrEqualTo(self $date): bool
    {
        return $this->toDateTimeImmutable() <= $date->toDateTimeImmutable();
    }

    public function isNotBeforeOrEqualTo(self $date): bool
    {
        return !($this->toDateTimeImmutable() <= $date->toDateTimeImmutable());
    }

    public function isAfter(self $date): bool
    {
        return $this->toDateTimeImmutable() > $date->toDateTimeImmutable();
    }

    public function isNotAfter(self $date): bool
    {
        return !($this->toDateTimeImmutable() > $date->toDateTimeImmutable());
    }

    public function isAfterOrEqualTo(self $date): bool
    {
        return $this->toDateTimeImmutable() >= $date->toDateTimeImmutable();
    }

    public function isNotAfterOrEqualTo(self $date): bool
    {
        return !($this->toDateTimeImmutable() >= $date->toDateTimeImmutable());
    }

    public function compareTo(self $date): int
    {
        return $this->toDateTimeImmutable() <=> $date->toDateTimeImmutable();
    }

    /**
     * Returns all dates until the given date. If the given date is before this date, the result will be an empty array.
     *
     * @return array<int, Date>
     */
    public function datesUntil(
        self $date,
        PeriodLimit $periodLimit = PeriodLimit::INCLUDING_START_AND_END,
    ): array {
        $startDateTime = $periodLimit === PeriodLimit::INCLUDING_START_AND_END
        || $periodLimit === PeriodLimit::INCLUDING_START
            ? $this
                ->modify('- 1 day')
                ->toDateTimeImmutable()
            : $this->toDateTimeImmutable();

        $endDateTime = $periodLimit === PeriodLimit::INCLUDING_START_AND_END
        || $periodLimit === PeriodLimit::INCLUDING_END
            ? $date
                ->modify('+ 1 day')
                ->toDateTimeImmutable()
            : $date->toDateTimeImmutable();

        $interval = new \DateInterval('P1D');
        /**
         * The options here seem counter-intuitive, but are set in a way that this logic is only handled in one place (above) instead of
         * two place with part of it above and part below.
         */
        $period = new \DatePeriod($startDateTime, $interval, $endDateTime, \DatePeriod::EXCLUDE_START_DATE);

        $dates = [];
        foreach ($period as $dateTime) {
            $dates[] = self::fromDateTime($dateTime);
        }

        return $dates;
    }

    public function weekday(): Weekday
    {
        return Weekday::fromDateTime($this->toDateTimeImmutable());
    }

    // -- Guards

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\DateIsNotEqual
     */
    public function mustBeEqualTo(
        self $date,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isNotEqualTo($date)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\DateIsNotEqual();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\DateIsEqual
     */
    public function mustNotBeEqualTo(
        self $date,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isEqualTo($date)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\DateIsEqual();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\DateIsNotAfter
     */
    public function mustBeAfter(
        self $date,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isNotAfter($date)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\DateIsNotAfter();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\DateIsAfter
     */
    public function mustNotBeAfter(
        self $date,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isAfter($date)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\DateIsAfter();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\DateIsNotAfterOrEqualTo
     */
    public function mustBeAfterOrEqualTo(
        self $date,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isNotAfterOrEqualTo($date)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\DateIsNotAfterOrEqualTo();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\DateIsAfterOrEqualTo
     */
    public function mustNotBeAfterOrEqualTo(
        self $date,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isAfterOrEqualTo($date)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\DateIsAfterOrEqualTo();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\DateIsNotBefore
     */
    public function mustBeBefore(
        self $date,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isNotBefore($date)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\DateIsNotBefore();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\DateIsBefore
     */
    public function mustNotBeBefore(
        self $date,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isBefore($date)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\DateIsBefore();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\DateIsNotBeforeOrEqualTo
     */
    public function mustBeBeforeOrEqualTo(
        self $date,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isNotBeforeOrEqualTo($date)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\DateIsNotBeforeOrEqualTo();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\DateIsBeforeOrEqualTo
     */
    public function mustNotBeBeforeOrEqualTo(
        self $date,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isBeforeOrEqualTo($date)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\DateIsBeforeOrEqualTo();
        }
    }

    // -- Mutations

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
                '%d-%d-%d 00:00:00',
                $this->month->year->year,
                $this->month->month,
                $this->day,
            ),
            $timeZone,
        );
    }

    public function modifyInTimeZone(string $modify, \DateTimeZone $timeZone): self
    {
        $dateTimeImmutable = new \DateTimeImmutable(
            sprintf(
                '%d-%d-%d 00:00:00',
                $this->month->year->year,
                $this->month->month,
                $this->day,
            ),
            $timeZone,
        );

        /** @psalm-suppress PossiblyFalseArgument */
        return self::fromDateTime($dateTimeImmutable->modify($modify));
    }

    private function toDateTimeImmutable(): \DateTimeImmutable
    {
        return new \DateTimeImmutable(
            sprintf(
                '%d-%d-%d 00:00:00',
                $this->month->year->year,
                $this->month->month,
                $this->day,
            ),
        );
    }
}
