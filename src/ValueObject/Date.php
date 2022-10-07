<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeUtils\ValueObject;

/** @psalm-immutable */
final class Date implements \Stringable
{
    private const DATE_FORMAT = 'Y-m-d';

    // -- Construction

    public function __construct(
        public readonly Month $month,
        public readonly int $dayOfMonth,
    ) {
    }

    public static function fromDateTime(\DateTimeImmutable $dateTime): self
    {
        /** @psalm-suppress PossiblyNullArrayAccess */
        [$year, $month, $dayOfMonth] = sscanf(
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
            $dayOfMonth,
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

    // Stringable

    public function __toString(): string
    {
        return $this->format(self::DATE_FORMAT);
    }

    // Accessors

    public function isEqualTo(self $day): bool
    {
        return $this->dayOfMonth === $day->dayOfMonth
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

        return $this->dayOfMonth < $day->dayOfMonth;
    }

    public function isBeforeOrEqualTo(self $day): bool
    {
        if ($this->month->isBefore($day->month)) {
            return true;
        }

        if ($this->month->isAfter($day->month)) {
            return false;
        }

        return $this->dayOfMonth <= $day->dayOfMonth;
    }

    public function isAfter(self $day): bool
    {
        if ($this->month->isAfter($day->month)) {
            return true;
        }

        if ($this->month->isBefore($day->month)) {
            return false;
        }

        return $this->dayOfMonth > $day->dayOfMonth;
    }

    public function isAfterOrEqualTo(self $day): bool
    {
        if ($this->month->isAfter($day->month)) {
            return true;
        }

        if ($this->month->isBefore($day->month)) {
            return false;
        }

        return $this->dayOfMonth >= $day->dayOfMonth;
    }

    // Mutations

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
                '%d-%d-%d 00:00:00',
                $this->month->year->year,
                $this->month->monthOfYear,
                $this->dayOfMonth,
            ),
        );
    }
}
