<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeUtils\ValueObject;

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

    public function previous(): self
    {
        // TODO: Implement
        return $this;
    }

    public function next(): self
    {
        // TODO: Implement
        return $this;
    }

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

    // -- Mutations

    public function format(string $format): string
    {
        return $this
            ->toDateTimeImmutable()
            ->format($format);
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
