<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * @psalm-type NormalizedCalendarUnits = list<string>
 *
 * @implements \IteratorAggregate<int, CalendarUnit>
 */
final readonly class CalendarUnits implements ArrayNormalizable, NullableArrayDenormalizable, \Countable, \IteratorAggregate
{
    use NullableArrayDenormalizableTrait;

    // -- Construction

    /**
     * @param list<CalendarUnit> $calendarUnits
     *
     * @throws Exception\CollectionContainsDuplicates
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
                    throw new Exception\CollectionContainsDuplicates(self::class);
                }
            }
        }
    }

    /**
     * Keeps the first occurrence of every value.
     *
     * @param list<CalendarUnit> $calendarUnits
     */
    public static function fromListRemovingDuplicates(array $calendarUnits): self
    {
        $uniqueCalendarUnits = [];
        foreach ($calendarUnits as $calendarUnit) {
            foreach ($uniqueCalendarUnits as $uniqueCalendarUnit) {
                if ($uniqueCalendarUnit === $calendarUnit) {
                    continue 2;
                }
            }

            $uniqueCalendarUnits[] = $calendarUnit;
        }

        return new self($uniqueCalendarUnits);
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

    // -- Countable

    #[\Override]
    public function count(): int
    {
        return count($this->calendarUnits);
    }

    // -- IteratorAggregate

    /**
     * @return \Iterator<int, CalendarUnit>
     */
    #[\Override]
    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->calendarUnits);
    }

    // -- Accessors

    public function isEmpty(): bool
    {
        return $this->calendarUnits === [];
    }

    public function isNotEmpty(): bool
    {
        return $this->calendarUnits !== [];
    }

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

    /**
     * Collections are equal when they contain the same values, independent of their order.
     */
    public function isEqualTo(self $calendarUnits): bool
    {
        if (count($this->calendarUnits) !== count($calendarUnits->calendarUnits)) {
            return false;
        }

        foreach ($this->calendarUnits as $calendarUnit) {
            if ($calendarUnits->notContains($calendarUnit)) {
                return false;
            }
        }

        return true;
    }

    public function isNotEqualTo(self $calendarUnits): bool
    {
        return !$this->isEqualTo($calendarUnits);
    }

    public function first(): ?CalendarUnit
    {
        return $this->calendarUnits[0] ?? null;
    }

    public function last(): ?CalendarUnit
    {
        $lastKey = array_key_last($this->calendarUnits);

        return $lastKey !== null
            ? $this->calendarUnits[$lastKey]
            : null;
    }

    /**
     * @template T
     *
     * @param callable(CalendarUnit): T $mapper
     *
     * @return list<T>
     */
    public function map(callable $mapper): array
    {
        return array_map($mapper, $this->calendarUnits);
    }

    // -- Mutations

    /**
     * @param callable(CalendarUnit): bool $filter
     */
    public function filter(callable $filter): self
    {
        return new self(array_values(array_filter($this->calendarUnits, $filter)));
    }

    /**
     * @param callable(CalendarUnit, CalendarUnit): int $comparator
     */
    public function sort(callable $comparator): self
    {
        $calendarUnits = $this->calendarUnits;
        usort($calendarUnits, $comparator);

        return new self($calendarUnits);
    }
}
