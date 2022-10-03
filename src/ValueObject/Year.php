<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeUtils\ValueObject;

/** @psalm-immutable */
final class Year
{
    public function __construct(
        public readonly int $number,
    ) {
    }

    public function isEqualTo(self $year): bool
    {
        return $this->number === $year->number;
    }

    public function isBefore(self $year): bool
    {
        return $this->number < $year->number;
    }

    public function isBeforeOrEqualTo(self $year): bool
    {
        return $this->number <= $year->number;
    }

    public function isAfter(self $year): bool
    {
        return $this->number > $year->number;
    }

    public function isAfterOrEqualTo(self $year): bool
    {
        return $this->number >= $year->number;
    }
}
