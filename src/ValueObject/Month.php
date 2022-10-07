<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeUtils\ValueObject;

/** @psalm-immutable */
final class Month
{
    public function __construct(
        public readonly Year $year,
        public readonly int $monthOfYear,
    ) {
    }

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
}
