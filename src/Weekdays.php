<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;

final readonly class Weekdays implements ArrayNormalizable
{
    // -- Construction

    /**
     * @param array<int, Weekday> $weekdays
     */
    public function __construct(
        /**
         * @var array<int, Weekday> $weekdays
         */
        public array $weekdays,
    ) {
        $enumValues = [];
        foreach ($this->weekdays as $weekday) {
            $enumValues[] = $weekday->value;
        }
        if (count($enumValues) !== count(array_unique($enumValues))) {
            throw new \InvalidArgumentException('Weekdays must be unique.');
        }
    }

    // -- Array normalizable

    /**
     * @param array<int, string> $data
     */
    public static function denormalize(array $data): self
    {
        $weekdays = [];
        foreach ($data as $value) {
            $weekdays[] = Weekday::from($value);
        }

        return new self($weekdays);
    }

    /**
     * @return array<int, string>
     */
    public function normalize(): array
    {
        $weekdayStrings = [];
        foreach ($this->weekdays as $weekday) {
            $weekdayStrings[] = $weekday->value;
        }

        return $weekdayStrings;
    }

    // -- Accessors

    public function contains(Weekday $weekday): bool
    {
        return in_array($weekday, $this->weekdays, true);
    }

    public function notContains(Weekday $weekday): bool
    {
        return !in_array($weekday, $this->weekdays, true);
    }
}
