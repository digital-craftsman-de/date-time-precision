<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts;

/** @psalm-immutable */
final class Year
{
    // -- Construction

    public function __construct(
        public readonly int $year,
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

    public function isAfter(self $year): bool
    {
        return $this->year > $year->year;
    }

    public function isAfterOrEqualTo(self $year): bool
    {
        return $this->year >= $year->year;
    }

    public function compareTo(self $year): int
    {
        return $this->year <=> $year->year;
    }

    /**
     * Returns all years until the given year. If the given year is before this year, the result will be an empty array.
     *
     * @return array<int, Year>
     */
    public function yearsUntil(
        self $year,
        PeriodLimit $periodLimit = PeriodLimit::INCLUDING_START_AND_END,
    ): array {
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

        return $years;
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

    public function toDateTimeInTimeZone(\DateTimeZone $timeZone): DateTime
    {
        return DateTime::fromStringInTimeZone(
            sprintf(
                '%d-01-01 00:00:00',
                $this->year,
            ),
            $timeZone,
        );
    }

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
