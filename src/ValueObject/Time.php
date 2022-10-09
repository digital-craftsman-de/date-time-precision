<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\ValueObject;

/** @psalm-immutable */
final class Time implements \Stringable
{
    private const TIME_FORMAT = 'H:i:s.u';
    private const MINUTES_IN_AN_HOUR = 60;

    // -- Construction

    public function __construct(
        public readonly int $hour,
        public readonly int $minute,
        public readonly int $second,
        public readonly int $microsecond = 0,
    ) {
        if ($this->hour < 0
            || $this->hour > 23
        ) {
            throw new \InvalidArgumentException('Hour must be greater or equal 0 and less or equal than 23');
        }

        if ($this->minute < 0
            || $this->minute >= 60
        ) {
            throw new \InvalidArgumentException('Minute must be greater or equal 0 and less than 60');
        }

        if ($this->second < 0
            || $this->second >= 60
        ) {
            throw new \InvalidArgumentException('Second must be greater or equal 0 and less than 60');
        }

        if ($this->microsecond < 0
            || $this->microsecond >= 1000000
        ) {
            throw new \InvalidArgumentException('Microsecond must be greater or equal 0 and less than 1000000');
        }
    }

    public static function fromDateTime(\DateTimeImmutable $dateTime): self
    {
        /** @psalm-suppress PossiblyNullArrayAccess */
        [$hour, $minute, $second, $microsecond] = sscanf(
            $dateTime->format('H-i-s.u'),
            '%d-%d-%d.%d',
        );

        /**
         * @psalm-suppress PossiblyNullArgument
         * @psalm-suppress PossiblyInvalidArgument
         */
        return new self(
            $hour,
            $minute,
            $second,
            $microsecond,
        );
    }

    public static function fromString(string $time): self
    {
        try {
            return self::fromDateTime(new \DateTimeImmutable($time));
        } catch (\Exception) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is not valid time format.', $time));
        }
    }

    // Stringable

    public function __toString(): string
    {
        return $this->format(self::TIME_FORMAT);
    }

    // -- Accessors

    public function isAfter(self $time): bool
    {
        $thisAsDateTime = $this->toDateTimeImmutable();
        $comparedTo = $thisAsDateTime->setTime(
            $time->hour,
            $time->minute,
            $time->second,
            $time->microsecond,
        );

        return $thisAsDateTime > $comparedTo;
    }

    public function isAfterOrEqualTo(self $time): bool
    {
        $thisAsDateTime = $this->toDateTimeImmutable();
        $comparedTo = $thisAsDateTime->setTime(
            $time->hour,
            $time->minute,
            $time->second,
            $time->microsecond,
        );

        return $thisAsDateTime >= $comparedTo;
    }

    public function isEqualTo(self $time): bool
    {
        $thisAsDateTime = $this->toDateTimeImmutable();
        $comparedTo = $thisAsDateTime->setTime(
            $time->hour,
            $time->minute,
            $time->second,
            $time->microsecond,
        );

        return $thisAsDateTime == $comparedTo;
    }

    public function isNotEqualTo(self $time): bool
    {
        return !$this->isEqualTo($time);
    }

    public function isBefore(self $time): bool
    {
        $thisAsDateTime = $this->toDateTimeImmutable();
        $comparedTo = $thisAsDateTime->setTime(
            $time->hour,
            $time->minute,
            $time->second,
            $time->microsecond,
        );

        return $thisAsDateTime < $comparedTo;
    }

    public function isBeforeOrEqualTo(self $time): bool
    {
        $thisAsDateTime = $this->toDateTimeImmutable();
        $comparedTo = $thisAsDateTime->setTime(
            $time->hour,
            $time->minute,
            $time->second,
            $time->microsecond,
        );

        return $thisAsDateTime <= $comparedTo;
    }

    public function isMidnight(): bool
    {
        return $this->hour === 0
            && $this->minute === 0
            && $this->second === 0
            && $this->microsecond === 0;
    }

    public function isNotMidnight(): bool
    {
        return !$this->isMidnight();
    }

    public function compareTo(self $time): int
    {
        if ($this->isEqualTo($time)) {
            return 0;
        }

        return $this->isBefore($time)
            ? -1
            : 1;
    }

    public function distanceInMinutesTo(self $time): int
    {
        $diff = $this->diff($time);

        return $diff->h * self::MINUTES_IN_AN_HOUR + $diff->i;
    }

    // -- Mutations

    public function format(string $format): string
    {
        return $this
            ->toDateTimeImmutable()
            ->format($format);
    }

    public function diff(self $time): \DateInterval
    {
        return $this
            ->toDateTimeImmutable()
            ->diff($time->toDateTimeImmutable());
    }

    public function modify(string $modifier): self
    {
        $modifiedDateTime = $this->toDateTimeImmutable()
            ->modify($modifier);

        if ($modifiedDateTime === false) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is not valid modifier.', $modifier));
        }

        return self::fromDateTime($modifiedDateTime);
    }

    private function toDateTimeImmutable(): \DateTimeImmutable
    {
        return new \DateTimeImmutable(
            sprintf(
                '2000-01-01 %d:%d:%d.%d',
                $this->hour,
                $this->minute,
                $this->second,
                $this->microsecond,
            ),
        );
    }
}
