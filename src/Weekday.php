<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

enum Weekday: string
{
    case MONDAY = 'MONDAY';
    case TUESDAY = 'TUESDAY';
    case WEDNESDAY = 'WEDNESDAY';
    case THURSDAY = 'THURSDAY';
    case FRIDAY = 'FRIDAY';
    case SATURDAY = 'SATURDAY';
    case SUNDAY = 'SUNDAY';

    // -- Construction

    public static function fromDateTime(\DateTimeImmutable $dateTime): self
    {
        return self::fromDayOfWeek((int) $dateTime->format('N'));
    }

    public static function fromDate(Date $date): self
    {
        return self::fromDayOfWeek((int) $date->format('N'));
    }

    public static function fromDayOfWeek(int $dayOfIsoWeek): self
    {
        return match ($dayOfIsoWeek) {
            1 => self::MONDAY,
            2 => self::TUESDAY,
            3 => self::WEDNESDAY,
            4 => self::THURSDAY,
            5 => self::FRIDAY,
            6 => self::SATURDAY,
            7 => self::SUNDAY,
        };
    }

    // -- Accessors

    public function dayOfWeek(): int
    {
        return match ($this) {
            self::MONDAY => 1,
            self::TUESDAY => 2,
            self::WEDNESDAY => 3,
            self::THURSDAY => 4,
            self::FRIDAY => 5,
            self::SATURDAY => 6,
            self::SUNDAY => 7,
        };
    }

    public function isEqualTo(self $weekday): bool
    {
        return $this === $weekday;
    }

    public function isNotEqualTo(self $weekday): bool
    {
        return $this !== $weekday;
    }

    public function isBefore(self $date): bool
    {
        return $this->dayOfWeek() < $date->dayOfWeek();
    }

    public function isNotBefore(self $date): bool
    {
        return !($this->dayOfWeek() < $date->dayOfWeek());
    }

    public function isBeforeOrEqualTo(self $date): bool
    {
        return $this->dayOfWeek() <= $date->dayOfWeek();
    }

    public function isNotBeforeOrEqualTo(self $date): bool
    {
        return !($this->dayOfWeek() <= $date->dayOfWeek());
    }

    public function isAfter(self $date): bool
    {
        return $this->dayOfWeek() > $date->dayOfWeek();
    }

    public function isNotAfter(self $date): bool
    {
        return !($this->dayOfWeek() > $date->dayOfWeek());
    }

    public function isAfterOrEqualTo(self $date): bool
    {
        return $this->dayOfWeek() >= $date->dayOfWeek();
    }

    public function isNotAfterOrEqualTo(self $date): bool
    {
        return !($this->dayOfWeek() >= $date->dayOfWeek());
    }

    public function compareTo(self $date): int
    {
        return $this->dayOfWeek() <=> $date->dayOfWeek();
    }
}
