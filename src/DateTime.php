<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

final readonly class DateTime implements \Stringable
{
    private const DATE_TIME_FORMAT = \DateTimeInterface::ATOM;

    // -- Construction

    public function __construct(
        public \DateTimeImmutable $dateTime,
    ) {
    }

    public static function fromString(string $string): self
    {
        return new self(new \DateTimeImmutable($string, new \DateTimeZone('UTC')));
    }

    public static function fromStringInTimeZone(
        string $string,
        \DateTimeZone $timeZone,
    ): self {
        $defaultTimeZone = new \DateTimeZone('UTC');

        return (new self(new \DateTimeImmutable($string, $timeZone)))
            ->toTimeZone($defaultTimeZone);
    }

    public static function fromDateTime(\DateTimeImmutable $dateTime): self
    {
        return new self($dateTime);
    }

    // Stringable

    public function __toString(): string
    {
        return $this->format(self::DATE_TIME_FORMAT);
    }

    // -- Accessors

    public function date(): Date
    {
        return Date::fromDateTime($this->dateTime);
    }

    public function dateInTimeZone(\DateTimeZone $timeZone): Date
    {
        return $this
            ->toTimeZone($timeZone)
            ->date();
    }

    public function time(): Time
    {
        return Time::fromDateTime($this->dateTime);
    }

    public function timeInTimeZone(\DateTimeZone $timeZone): Time
    {
        return $this
            ->toTimeZone($timeZone)
            ->time();
    }

    public function month(): Month
    {
        return Month::fromDateTime($this->dateTime);
    }

    public function monthInTimeZone(\DateTimeZone $timeZone): Month
    {
        return $this
            ->toTimeZone($timeZone)
            ->month();
    }

    public function year(): Year
    {
        return Year::fromDateTime($this->dateTime);
    }

    public function yearInTimeZone(\DateTimeZone $timeZone): Year
    {
        return $this
            ->toTimeZone($timeZone)
            ->year();
    }

    public function isEqualTo(self $dateTime): bool
    {
        return $this->dateTime == $dateTime->dateTime;
    }

    public function isNotEqualTo(self $dateTime): bool
    {
        return $this->dateTime != $dateTime->dateTime;
    }

    public function isAfter(self $dateTime): bool
    {
        return $this->dateTime > $dateTime->dateTime;
    }

    public function isNotAfter(self $dateTime): bool
    {
        return !($this->dateTime > $dateTime->dateTime);
    }

    public function isAfterOrEqualTo(self $dateTime): bool
    {
        return $this->dateTime >= $dateTime->dateTime;
    }

    public function isNotAfterOrEqualTo(self $dateTime): bool
    {
        return !($this->dateTime >= $dateTime->dateTime);
    }

    public function isBeforeOrEqualTo(self $dateTime): bool
    {
        return $this->dateTime <= $dateTime->dateTime;
    }

    public function isNotBeforeOrEqualTo(self $dateTime): bool
    {
        return !($this->dateTime <= $dateTime->dateTime);
    }

    public function isBefore(self $dateTime): bool
    {
        return $this->dateTime < $dateTime->dateTime;
    }

    public function isNotBefore(self $dateTime): bool
    {
        return !($this->dateTime < $dateTime->dateTime);
    }

    public function compareTo(self $dateTime): int
    {
        return $this->dateTime <=> $dateTime->dateTime;
    }

    public function isDateAfterInTimeZone(self $dateTime, \DateTimeZone $timeZone): bool
    {
        return $this->dateInTimeZone($timeZone)->isAfter(
            $dateTime->dateInTimeZone($timeZone),
        );
    }

    public function isDateNotAfterInTimeZone(self $dateTime, \DateTimeZone $timeZone): bool
    {
        return $this->dateInTimeZone($timeZone)->isNotAfter(
            $dateTime->dateInTimeZone($timeZone),
        );
    }

    public function isDateAfterOrEqualToInTimeZone(self $dateTime, \DateTimeZone $timeZone): bool
    {
        return $this->dateInTimeZone($timeZone)->isAfterOrEqualTo(
            $dateTime->dateInTimeZone($timeZone),
        );
    }

    public function isDateNotAfterOrEqualToInTimeZone(self $dateTime, \DateTimeZone $timeZone): bool
    {
        return $this->dateInTimeZone($timeZone)->isNotAfterOrEqualTo(
            $dateTime->dateInTimeZone($timeZone),
        );
    }

    public function isDateEqualToInTimeZone(self $dateTime, \DateTimeZone $timeZone): bool
    {
        return $this->dateInTimeZone($timeZone)->isEqualTo(
            $dateTime->dateInTimeZone($timeZone),
        );
    }

    public function isDateNotEqualToInTimeZone(self $dateTime, \DateTimeZone $timeZone): bool
    {
        return $this->dateInTimeZone($timeZone)->isNotEqualTo(
            $dateTime->dateInTimeZone($timeZone),
        );
    }

    public function isDateBeforeInTimeZone(self $dateTime, \DateTimeZone $timeZone): bool
    {
        return $this->dateInTimeZone($timeZone)->isBefore(
            $dateTime->dateInTimeZone($timeZone),
        );
    }

    public function isDateNotBeforeInTimeZone(self $dateTime, \DateTimeZone $timeZone): bool
    {
        return $this->dateInTimeZone($timeZone)->isNotBefore(
            $dateTime->dateInTimeZone($timeZone),
        );
    }

    public function isDateBeforeOrEqualToInTimeZone(self $dateTime, \DateTimeZone $timeZone): bool
    {
        return $this->dateInTimeZone($timeZone)->isBeforeOrEqualTo(
            $dateTime->dateInTimeZone($timeZone),
        );
    }

    public function isDateNotBeforeOrEqualToInTimeZone(self $dateTime, \DateTimeZone $timeZone): bool
    {
        return $this->dateInTimeZone($timeZone)->isNotBeforeOrEqualTo(
            $dateTime->dateInTimeZone($timeZone),
        );
    }

    public function isAtMidnight(): bool
    {
        return $this
            ->time()
            ->isMidnight();
    }

    public function isNotAtMidnight(): bool
    {
        return $this
            ->time()
            ->isNotMidnight();
    }

    public function isAtMidnightInTimeZone(\DateTimeZone $timeZone): bool
    {
        return $this
            ->timeInTimeZone($timeZone)
            ->isMidnight();
    }

    public function isNotAtMidnightInTimeZone(\DateTimeZone $timeZone): bool
    {
        return $this
            ->timeInTimeZone($timeZone)
            ->isNotMidnight();
    }

    // -- Modifications

    public function modify(string $modifier): self
    {
        /** @psalm-suppress PossiblyFalseArgument */
        return new self(
            $this->dateTime->modify($modifier),
        );
    }

    public function format(string $format): string
    {
        return $this->dateTime->format($format);
    }

    public function formatInTimeZone(string $format, \DateTimeZone $timeZone): string
    {
        return $this
            ->toTimeZone($timeZone)
            ->dateTime
            ->format($format);
    }

    public function toTimeZone(\DateTimeZone $timeZone): self
    {
        return new self(
            $this->dateTime->setTimezone($timeZone),
        );
    }

    public function modifyInTimeZone(string $modifier, \DateTimeZone $timeZone): self
    {
        $originalTimeZone = $this->dateTime->getTimezone();

        /** @psalm-suppress PossiblyFalseReference */
        return new self(
            $this->dateTime
                ->setTimezone($timeZone)
                ->modify($modifier)
                ->setTimezone($originalTimeZone),
        );
    }

    public function setTime(Time $time): self
    {
        return new self(
            $this->dateTime->setTime(
                $time->hour,
                $time->minute,
                $time->second,
                $time->microsecond,
            ),
        );
    }

    public function setTimeInTimeZone(Time $time, \DateTimeZone $timeZone): self
    {
        $originalTimeZone = $this->dateTime->getTimezone();

        return $this
            ->toTimeZone($timeZone)
            ->setTime($time)
            ->toTimeZone($originalTimeZone);
    }

    public function midnight(): self
    {
        return $this->setTime(new Time(
            0,
            0,
            0,
        ));
    }

    public function midnightInTimeZone(\DateTimeZone $timeZone): self
    {
        $originalTimeZone = $this->dateTime->getTimezone();

        return $this
            ->toTimeZone($timeZone)
            ->midnight()
            ->toTimeZone($originalTimeZone);
    }
}
