<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\ValueObject;

final class DateTime implements \Stringable
{
    private const DATE_TIME_FORMAT = \DateTimeInterface::ATOM;

    // -- Construction

    public function __construct(
        public readonly \DateTimeImmutable $dateTime,
    ) {
    }

    public static function fromString(string $string): self
    {
        return new self(new \DateTimeImmutable($string));
    }

    public static function fromStringInTimeZone(
        string $string,
        \DateTimeZone $timeZone,
    ): self {
        $defaultTimeZone = new \DateTimeZone(date_default_timezone_get());

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

    public function time(): Time
    {
        return Time::fromDateTime($this->dateTime);
    }

    public function month(): Month
    {
        return Month::fromDateTime($this->dateTime);
    }

    public function year(): Year
    {
        return Year::fromDateTime($this->dateTime);
    }

    public function timeZone(): \DateTimeZone
    {
        return $this->dateTime->getTimezone();
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

    public function isAfterOrEqualTo(self $dateTime): bool
    {
        return $this->dateTime >= $dateTime->dateTime;
    }

    public function isBeforeOrEqualTo(self $dateTime): bool
    {
        return $this->dateTime <= $dateTime->dateTime;
    }

    public function isBefore(self $dateTime): bool
    {
        return $this->dateTime < $dateTime->dateTime;
    }

    public function compareTo(self $dateTime): int
    {
        return $this->dateTime <=> $dateTime->dateTime;
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

    public function toTimeZone(\DateTimeZone $timeZone): self
    {
        return new self(
            $this->dateTime->setTimezone($timeZone),
        );
    }

    public function toUTC(): self
    {
        return new self(
            $this->dateTime->setTimezone(new \DateTimeZone('UTC')),
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
