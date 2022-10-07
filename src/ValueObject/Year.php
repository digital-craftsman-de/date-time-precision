<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeUtils\ValueObject;

/** @psalm-immutable */
final class Year
{
    public function __construct(
        public readonly int $year,
    ) {
    }

    public function isEqualTo(self $year): bool
    {
        return $this->year === $year->year;
    }

    public function isBefore(self $year): bool
    {
        return $this->year < $year->year;
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
}
