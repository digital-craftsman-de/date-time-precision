<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * @psalm-import-type NormalizedCalendarPeriod from CalendarPeriod
 *
 * @psalm-type NormalizedCalendarPeriods = list<NormalizedCalendarPeriod>
 */
final readonly class CalendarPeriods implements ArrayNormalizable, NullableArrayDenormalizable
{
    use NullableArrayDenormalizableTrait;

    // -- Construction

    /**
     * @param list<CalendarPeriod> $calendarPeriods
     */
    public function __construct(
        /**
         * @var list<CalendarPeriod>
         */
        public array $calendarPeriods,
    ) {
        foreach ($this->calendarPeriods as $index => $calendarPeriod) {
            for ($previousIndex = 0; $previousIndex < $index; ++$previousIndex) {
                if ($this->calendarPeriods[$previousIndex]->isEqualTo($calendarPeriod)) {
                    throw new \InvalidArgumentException('CalendarPeriods must be unique.');
                }
            }
        }
    }

    // -- Array normalizable

    /**
     * @param NormalizedCalendarPeriods $data
     */
    #[\Override]
    public static function denormalize(array $data): self
    {
        $calendarPeriods = [];
        foreach ($data as $value) {
            $calendarPeriods[] = CalendarPeriod::denormalize($value);
        }

        return new self($calendarPeriods);
    }

    /**
     * @return NormalizedCalendarPeriods
     */
    #[\Override]
    public function normalize(): array
    {
        $normalizedCalendarPeriods = [];
        foreach ($this->calendarPeriods as $calendarPeriod) {
            $normalizedCalendarPeriods[] = $calendarPeriod->normalize();
        }

        return $normalizedCalendarPeriods;
    }

    // -- Accessors

    public function contains(CalendarPeriod $calendarPeriod): bool
    {
        foreach ($this->calendarPeriods as $existingCalendarPeriod) {
            if ($existingCalendarPeriod->isEqualTo($calendarPeriod)) {
                return true;
            }
        }

        return false;
    }

    public function notContains(CalendarPeriod $calendarPeriod): bool
    {
        return !$this->contains($calendarPeriod);
    }
}
