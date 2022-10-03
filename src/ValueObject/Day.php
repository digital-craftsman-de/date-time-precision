<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeUtils\ValueObject;

/** @psalm-immutable */
final class Day
{
    public function __construct(
        public readonly Month $month,
        public readonly int $number,
    ) {
    }

    public static function fromDateTime(\DateTimeImmutable $dateTime): self
    {
        /** @psalm-suppress PossiblyNullArrayAccess */
        [$year, $month, $day] = sscanf(
            $dateTime->format('Y-m-d'),
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

    public function isEqualTo(self $day): bool
    {
        return $this->number === $day->number
            && $this->month->isEqualTo($day->month);
    }

    public function isNotEqualTo(self $day): bool
    {
        return !$this->isEqualTo($day);
    }

    public function isBefore(self $day): bool
    {
        if ($this->month->isBefore($day->month)) {
            return true;
        }

        if ($this->month->isAfter($day->month)) {
            return false;
        }

        return $this->number < $day->number;
    }

    public function isBeforeOrEqualTo(self $day): bool
    {
        if ($this->month->isBefore($day->month)) {
            return true;
        }

        if ($this->month->isAfter($day->month)) {
            return false;
        }

        return $this->number <= $day->number;
    }

    public function isAfter(self $day): bool
    {
        if ($this->month->isAfter($day->month)) {
            return true;
        }

        if ($this->month->isBefore($day->month)) {
            return false;
        }

        return $this->number > $day->number;
    }

    public function isAfterOrEqualTo(self $day): bool
    {
        if ($this->month->isAfter($day->month)) {
            return true;
        }

        if ($this->month->isBefore($day->month)) {
            return false;
        }

        return $this->number >= $day->number;
    }
}
