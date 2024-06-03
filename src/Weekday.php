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
        return self::fromDayOfIsoWeek((int) $dateTime->format('N'));
    }

    public static function fromDate(Date $date): self
    {
        return self::fromDayOfIsoWeek((int) $date->format('N'));
    }

    public static function fromDayOfIsoWeek(int $dayOfIsoWeek): self
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

    public function isoDayOfWeek(): int
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
}
