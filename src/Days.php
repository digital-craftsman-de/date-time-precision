<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * @psalm-type NormalizedDays = list<int>
 */
final readonly class Days implements ArrayNormalizable, NullableArrayDenormalizable
{
    use NullableArrayDenormalizableTrait;

    // -- Construction

    /**
     * @param list<Day> $days
     */
    public function __construct(
        /**
         * @var list<Day>
         */
        public array $days,
    ) {
        $intValues = [];
        foreach ($this->days as $day) {
            $intValues[] = $day->day;
        }
        if (count($intValues) !== count(array_unique($intValues))) {
            throw new \InvalidArgumentException('Days must be unique.');
        }
    }

    // -- Array normalizable

    /**
     * @param NormalizedDays $data
     */
    #[\Override]
    public static function denormalize(array $data): self
    {
        $weekdays = [];
        foreach ($data as $value) {
            $weekdays[] = Day::denormalize($value);
        }

        return new self($weekdays);
    }

    /**
     * @return NormalizedDays
     */
    #[\Override]
    public function normalize(): array
    {
        $dayInts = [];
        foreach ($this->days as $day) {
            $dayInts[] = $day->normalize();
        }

        return $dayInts;
    }

    // -- Accessors

    public function contains(Day $day): bool
    {
        return in_array($day, $this->days, false);
    }

    public function notContains(Day $day): bool
    {
        return !in_array($day, $this->days, false);
    }
}
