<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

enum CalendarMonth: string
{
    case JANUARY = 'JANUARY';
    case FEBRUARY = 'FEBRUARY';
    case MARCH = 'MARCH';
    case APRIL = 'APRIL';
    case MAY = 'MAY';
    case JUNE = 'JUNE';
    case JULY = 'JULY';
    case AUGUST = 'AUGUST';
    case SEPTEMBER = 'SEPTEMBER';
    case OCTOBER = 'OCTOBER';
    case NOVEMBER = 'NOVEMBER';
    case DECEMBER = 'DECEMBER';

    // -- Construction

    public static function fromDateTime(\DateTimeImmutable $dateTime): self
    {
        return self::fromMonthNumber((int) $dateTime->format('n'));
    }

    public static function fromDate(Date $date): self
    {
        return self::fromMonthNumber((int) $date->format('n'));
    }

    public static function fromMonthNumber(int $dayOfIsoWeek): self
    {
        return match ($dayOfIsoWeek) {
            1 => self::JANUARY,
            2 => self::FEBRUARY,
            3 => self::MARCH,
            4 => self::APRIL,
            5 => self::MAY,
            6 => self::JUNE,
            7 => self::JULY,
            8 => self::AUGUST,
            9 => self::SEPTEMBER,
            10 => self::OCTOBER,
            11 => self::NOVEMBER,
            12 => self::DECEMBER,
        };
    }

    // -- Accessors

    public function numberOfMonth(): int
    {
        return match ($this) {
            self::JANUARY => 1,
            self::FEBRUARY => 2,
            self::MARCH => 3,
            self::APRIL => 4,
            self::MAY => 5,
            self::JUNE => 6,
            self::JULY => 7,
            self::AUGUST => 8,
            self::SEPTEMBER => 9,
            self::OCTOBER => 10,
            self::NOVEMBER => 11,
            self::DECEMBER => 12,
        };
    }

    public function isEqualTo(self $calendarMonth): bool
    {
        return $this === $calendarMonth;
    }

    public function isNotEqualTo(self $calendarMonth): bool
    {
        return $this !== $calendarMonth;
    }
}
