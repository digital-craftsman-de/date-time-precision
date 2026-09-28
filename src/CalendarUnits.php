<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * @psalm-type NormalizedCalendarUnits = list<string>
 */
final readonly class CalendarUnits implements ArrayNormalizable, NullableArrayDenormalizable
{
    use NullableArrayDenormalizableTrait;

    // -- Construction

    /**
     * @param list<CalendarUnit> $calendarUnits
     */
    public function __construct(
        /**
         * @var list<CalendarUnit>
         */
        public array $calendarUnits,
    ) {
        foreach ($this->calendarUnits as $index => $calendarUnit) {
            for ($previousIndex = 0; $previousIndex < $index; ++$previousIndex) {
                if ($this->calendarUnits[$previousIndex] === $calendarUnit) {
                    throw new \InvalidArgumentException('CalendarUnits must be unique.');
                }
            }
        }
    }

    // -- Array normalizable

    /**
     * @param NormalizedCalendarUnits $data
     */
    #[\Override]
    public static function denormalize(array $data): self
    {
        $calendarUnits = [];
        foreach ($data as $value) {
            $calendarUnits[] = CalendarUnit::denormalize($value);
        }

        return new self($calendarUnits);
    }

    /**
     * @return NormalizedCalendarUnits
     */
    #[\Override]
    public function normalize(): array
    {
        $normalizedCalendarUnits = [];
        foreach ($this->calendarUnits as $calendarUnit) {
            $normalizedCalendarUnits[] = $calendarUnit->normalize();
        }

        return $normalizedCalendarUnits;
    }

    // -- Accessors

    public function contains(CalendarUnit $calendarUnit): bool
    {
        foreach ($this->calendarUnits as $existingCalendarUnit) {
            if ($existingCalendarUnit === $calendarUnit) {
                return true;
            }
        }

        return false;
    }

    public function notContains(CalendarUnit $calendarUnit): bool
    {
        return !$this->contains($calendarUnit);
    }
}
