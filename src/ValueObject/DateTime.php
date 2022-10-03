<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeUtils\ValueObject;

final class DateTime
{
    // -- Construction

    public function __construct(
        public readonly \DateTimeImmutable $dateTime,
    ) {
    }

    public static function fromString(string $string): self
    {
        return new self(new \DateTimeImmutable($string));
    }

    // -- Accessors

    public function time(): Time
    {
        return Time::fromDateTime($this->dateTime);
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
}
