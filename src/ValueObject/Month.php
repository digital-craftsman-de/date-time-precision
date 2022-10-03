<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeUtils\ValueObject;

/** @psalm-immutable */
final class Month
{
    public function __construct(
        public readonly Year $year,
        public readonly int $number,
    ) {
    }

    public function isEqualTo(self $month): bool
    {
        return $this->number === $month->number
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

        return $this->number < $month->number;
    }

    public function isBeforeOrEqualTo(self $month): bool
    {
        if ($this->year->isBefore($month->year)) {
            return true;
        }

        if ($this->year->isAfter($month->year)) {
            return false;
        }

        return $this->number <= $month->number;
    }

    public function isAfter(self $month): bool
    {
        if ($this->year->isAfter($month->year)) {
            return true;
        }

        if ($this->year->isBefore($month->year)) {
            return false;
        }

        return $this->number > $month->number;
    }

    public function isAfterOrEqualTo(self $month): bool
    {
        if ($this->year->isAfter($month->year)) {
            return true;
        }

        if ($this->year->isBefore($month->year)) {
            return false;
        }

        return $this->number >= $month->number;
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

    public function firstDay(): Day
    {
        $firstDayOfMonth = new \DateTimeImmutable(sprintf(
            'first day of %d-%d',
            $this->year->number,
            $this->number,
        ));

        return Day::fromDateTime($firstDayOfMonth);
    }

    public function lastDay(): Day
    {
        $lastDayOfMonth = new \DateTimeImmutable(sprintf(
            'first day of %d-%d',
            $this->year->number,
            $this->number,
        ));

        return Day::fromDateTime($lastDayOfMonth);
    }
}
