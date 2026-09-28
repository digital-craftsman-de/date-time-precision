<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * @psalm-type NormalizedDates = list<string>
 */
final readonly class Dates implements ArrayNormalizable, NullableArrayDenormalizable
{
    use NullableArrayDenormalizableTrait;

    // -- Construction

    /**
     * @param list<Date> $dates
     */
    public function __construct(
        /**
         * @var list<Date>
         */
        public array $dates,
    ) {
        foreach ($this->dates as $index => $date) {
            for ($previousIndex = 0; $previousIndex < $index; ++$previousIndex) {
                if ($this->dates[$previousIndex]->isEqualTo($date)) {
                    throw new \InvalidArgumentException('Dates must be unique.');
                }
            }
        }
    }

    // -- Array normalizable

    /**
     * @param NormalizedDates $data
     */
    #[\Override]
    public static function denormalize(array $data): self
    {
        $dates = [];
        foreach ($data as $value) {
            $dates[] = Date::denormalize($value);
        }

        return new self($dates);
    }

    /**
     * @return NormalizedDates
     */
    #[\Override]
    public function normalize(): array
    {
        $normalizedDates = [];
        foreach ($this->dates as $date) {
            $normalizedDates[] = $date->normalize();
        }

        return $normalizedDates;
    }

    // -- Accessors

    public function contains(Date $date): bool
    {
        foreach ($this->dates as $existingDate) {
            if ($existingDate->isEqualTo($date)) {
                return true;
            }
        }

        return false;
    }

    public function notContains(Date $date): bool
    {
        return !$this->contains($date);
    }
}
