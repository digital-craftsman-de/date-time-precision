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
 *
 * @implements \IteratorAggregate<int, CalendarPeriod>
 */
final readonly class CalendarPeriods implements ArrayNormalizable, NullableArrayDenormalizable, \Countable, \IteratorAggregate
{
    use NullableArrayDenormalizableTrait;

    // -- Construction

    /**
     * @param list<CalendarPeriod> $calendarPeriods
     *
     * @throws Exception\CollectionContainsDuplicates
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
                    throw new Exception\CollectionContainsDuplicates(self::class);
                }
            }
        }
    }

    /**
     * Keeps the first occurrence of every value.
     *
     * @param list<CalendarPeriod> $calendarPeriods
     */
    public static function fromListRemovingDuplicates(array $calendarPeriods): self
    {
        $uniqueCalendarPeriods = [];
        foreach ($calendarPeriods as $calendarPeriod) {
            foreach ($uniqueCalendarPeriods as $uniqueCalendarPeriod) {
                if ($uniqueCalendarPeriod->isEqualTo($calendarPeriod)) {
                    continue 2;
                }
            }

            $uniqueCalendarPeriods[] = $calendarPeriod;
        }

        return new self($uniqueCalendarPeriods);
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

    // -- Countable

    #[\Override]
    public function count(): int
    {
        return count($this->calendarPeriods);
    }

    // -- IteratorAggregate

    /**
     * @return \Iterator<int, CalendarPeriod>
     */
    #[\Override]
    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->calendarPeriods);
    }

    // -- Accessors

    public function isEmpty(): bool
    {
        return $this->calendarPeriods === [];
    }

    public function isNotEmpty(): bool
    {
        return $this->calendarPeriods !== [];
    }

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

    /**
     * Collections are equal when they contain the same values, independent of their order.
     */
    public function isEqualTo(self $calendarPeriods): bool
    {
        if (count($this->calendarPeriods) !== count($calendarPeriods->calendarPeriods)) {
            return false;
        }

        foreach ($this->calendarPeriods as $calendarPeriod) {
            if ($calendarPeriods->notContains($calendarPeriod)) {
                return false;
            }
        }

        return true;
    }

    public function isNotEqualTo(self $calendarPeriods): bool
    {
        return !$this->isEqualTo($calendarPeriods);
    }

    public function first(): ?CalendarPeriod
    {
        return $this->calendarPeriods[0] ?? null;
    }

    public function last(): ?CalendarPeriod
    {
        $lastKey = array_key_last($this->calendarPeriods);

        return $lastKey !== null
            ? $this->calendarPeriods[$lastKey]
            : null;
    }

    /**
     * @template T
     *
     * @param callable(CalendarPeriod): T $mapper
     *
     * @return list<T>
     */
    public function map(callable $mapper): array
    {
        return array_map($mapper, $this->calendarPeriods);
    }

    // -- Mutations

    /**
     * @param callable(CalendarPeriod): bool $filter
     */
    public function filter(callable $filter): self
    {
        return new self(array_values(array_filter($this->calendarPeriods, $filter)));
    }

    /**
     * @param callable(CalendarPeriod, CalendarPeriod): int $comparator
     */
    public function sort(callable $comparator): self
    {
        $calendarPeriods = $this->calendarPeriods;
        usort($calendarPeriods, $comparator);

        return new self($calendarPeriods);
    }
}
