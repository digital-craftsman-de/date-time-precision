<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\StringNormalizable;

enum Weekday: string implements StringNormalizable
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
        $dayOfWeek = (int) $dateTime->format('N');

        return match ($dayOfWeek) {
            1 => self::MONDAY,
            2 => self::TUESDAY,
            3 => self::WEDNESDAY,
            4 => self::THURSDAY,
            5 => self::FRIDAY,
            6 => self::SATURDAY,
            7 => self::SUNDAY,
        };
    }

    // -- String normalizable

    #[\Override]
    public static function denormalize(string $data): self
    {
        return self::from($data);
    }

    #[\Override]
    public function normalize(): string
    {
        return $this->value;
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
