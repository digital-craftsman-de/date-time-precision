<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;

/**
 * @psalm-type NormalizedWeekdays = list<string>
 */
final readonly class Weekdays implements ArrayNormalizable
{
    // -- Construction

    /**
     * @param list<Weekday> $weekdays
     */
    public function __construct(
        /**
         * @var list<Weekday>
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
     * @param NormalizedWeekdays $data
     */
    #[\Override]
    public static function denormalize(array $data): self
    {
        $weekdays = [];
        foreach ($data as $value) {
            $weekdays[] = Weekday::denormalize($value);
        }

        return new self($weekdays);
    }

    /**
     * @return NormalizedWeekdays
     */
    #[\Override]
    public function normalize(): array
    {
        $weekdayStrings = [];
        foreach ($this->weekdays as $weekday) {
            $weekdayStrings[] = $weekday->normalize();
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
