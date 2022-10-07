<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\ValueObject;

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

    // -- Accessors

    public function isEqualTo(self $year): bool
    {
        return $this->year === $year->year;
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
