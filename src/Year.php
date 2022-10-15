<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts;

/** @psalm-immutable */
final class Year
{
    // -- Construction

    public function __construct(
        public readonly int $year,
    ) {
    }

    public static function fromDateTime(\DateTimeImmutable $dateTime): self
    {
        $year = (int) $dateTime->format('Y');

        return new self($year);
    }

    /** @param string $year Has to be date format `Y` */
    public static function fromString(string $year): self
    {
        $dateTime = \DateTimeImmutable::createFromFormat('Y', $year);
        if ($dateTime === false) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is not valid year format.', $year));
        }

        return self::fromDateTime($dateTime);
    }

    // -- Accessors

    public function isEqualTo(self $year): bool
    {
        return $this->year === $year->year;
    }

    public function isNotEqualTo(self $year): bool
    {
        return $this->year !== $year->year;
    }

    public function isBefore(self $year): bool
    {
        return $this->year < $year->year;
    }

    public function isBeforeOrEqualTo(self $year): bool
    {
        return $this->year <= $year->year;
    }

    public function isAfter(self $year): bool
    {
        return $this->year > $year->year;
    }

    public function isAfterOrEqualTo(self $year): bool
    {
        return $this->year >= $year->year;
    }

    // -- Mutations

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
                '%d-01-01 00:00:00',
                $this->year,
            ),
        );
    }
}
