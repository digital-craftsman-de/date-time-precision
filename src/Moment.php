<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

final readonly class Moment implements \Stringable
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

    public function isEqualTo(self $moment): bool
    {
        return $this->dateTime == $moment->dateTime;
    }

    public function isNotEqualTo(self $moment): bool
    {
        return $this->dateTime != $moment->dateTime;
    }

    public function isAfter(self $moment): bool
    {
        return $this->dateTime > $moment->dateTime;
    }

    public function isNotAfter(self $moment): bool
    {
        return !($this->dateTime > $moment->dateTime);
    }

    public function isAfterOrEqualTo(self $moment): bool
    {
        return $this->dateTime >= $moment->dateTime;
    }

    public function isNotAfterOrEqualTo(self $moment): bool
    {
        return !($this->dateTime >= $moment->dateTime);
    }

    public function isBeforeOrEqualTo(self $moment): bool
    {
        return $this->dateTime <= $moment->dateTime;
    }

    public function isNotBeforeOrEqualTo(self $moment): bool
    {
        return !($this->dateTime <= $moment->dateTime);
    }

    public function isBefore(self $moment): bool
    {
        return $this->dateTime < $moment->dateTime;
    }

    public function isNotBefore(self $moment): bool
    {
        return !($this->dateTime < $moment->dateTime);
    }

    public function compareTo(self $moment): int
    {
        return $this->dateTime <=> $moment->dateTime;
    }

    public function isDateAfterInTimeZone(self $moment, \DateTimeZone $timeZone): bool
    {
        return $this->dateInTimeZone($timeZone)->isAfter(
            $moment->dateInTimeZone($timeZone),
        );
    }

    public function isDateNotAfterInTimeZone(self $moment, \DateTimeZone $timeZone): bool
    {
        return $this->dateInTimeZone($timeZone)->isNotAfter(
            $moment->dateInTimeZone($timeZone),
        );
    }

    public function isDateAfterOrEqualToInTimeZone(self $moment, \DateTimeZone $timeZone): bool
    {
        return $this->dateInTimeZone($timeZone)->isAfterOrEqualTo(
            $moment->dateInTimeZone($timeZone),
        );
    }

    public function isDateNotAfterOrEqualToInTimeZone(self $moment, \DateTimeZone $timeZone): bool
    {
        return $this->dateInTimeZone($timeZone)->isNotAfterOrEqualTo(
            $moment->dateInTimeZone($timeZone),
        );
    }

    public function isDateEqualToInTimeZone(self $moment, \DateTimeZone $timeZone): bool
    {
        return $this->dateInTimeZone($timeZone)->isEqualTo(
            $moment->dateInTimeZone($timeZone),
        );
    }

    public function isDateNotEqualToInTimeZone(self $moment, \DateTimeZone $timeZone): bool
    {
        return $this->dateInTimeZone($timeZone)->isNotEqualTo(
            $moment->dateInTimeZone($timeZone),
        );
    }

    public function isDateBeforeInTimeZone(self $moment, \DateTimeZone $timeZone): bool
    {
        return $this->dateInTimeZone($timeZone)->isBefore(
            $moment->dateInTimeZone($timeZone),
        );
    }

    public function isDateNotBeforeInTimeZone(self $moment, \DateTimeZone $timeZone): bool
    {
        return $this->dateInTimeZone($timeZone)->isNotBefore(
            $moment->dateInTimeZone($timeZone),
        );
    }

    public function isDateBeforeOrEqualToInTimeZone(self $moment, \DateTimeZone $timeZone): bool
    {
        return $this->dateInTimeZone($timeZone)->isBeforeOrEqualTo(
            $moment->dateInTimeZone($timeZone),
        );
    }

    public function isDateNotBeforeOrEqualToInTimeZone(self $moment, \DateTimeZone $timeZone): bool
    {
        return $this->dateInTimeZone($timeZone)->isNotBeforeOrEqualTo(
            $moment->dateInTimeZone($timeZone),
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
