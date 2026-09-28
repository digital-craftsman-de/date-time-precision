<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * @psalm-type NormalizedWeekdays = list<string>
 *
 * @implements \IteratorAggregate<int, Weekday>
 */
final readonly class Weekdays implements ArrayNormalizable, NullableArrayDenormalizable, \Countable, \IteratorAggregate
{
    use NullableArrayDenormalizableTrait;

    // -- Construction

    /**
     * @param list<Weekday> $weekdays
     *
     * @throws Exception\CollectionContainsDuplicates
     */
    public function __construct(
        /**
         * @var list<Weekday>
         */
        public array $weekdays,
    ) {
        foreach ($this->weekdays as $index => $weekday) {
            for ($previousIndex = 0; $previousIndex < $index; ++$previousIndex) {
                if ($this->weekdays[$previousIndex] === $weekday) {
                    throw new Exception\CollectionContainsDuplicates(self::class);
                }
            }
        }
    }

    /**
     * Keeps the first occurrence of every value.
     *
     * @param list<Weekday> $weekdays
     */
    public static function fromListRemovingDuplicates(array $weekdays): self
    {
        $uniqueWeekdays = [];
        foreach ($weekdays as $weekday) {
            foreach ($uniqueWeekdays as $uniqueWeekday) {
                if ($uniqueWeekday === $weekday) {
                    continue 2;
                }
            }

            $uniqueWeekdays[] = $weekday;
        }

        return new self($uniqueWeekdays);
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
        $normalizedWeekdays = [];
        foreach ($this->weekdays as $weekday) {
            $normalizedWeekdays[] = $weekday->normalize();
        }

        return $normalizedWeekdays;
    }

    // -- Countable

    #[\Override]
    public function count(): int
    {
        return count($this->weekdays);
    }

    // -- IteratorAggregate

    /**
     * @return \Iterator<int, Weekday>
     */
    #[\Override]
    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->weekdays);
    }

    // -- Accessors

    public function isEmpty(): bool
    {
        return $this->weekdays === [];
    }

    public function isNotEmpty(): bool
    {
        return $this->weekdays !== [];
    }

    public function contains(Weekday $weekday): bool
    {
        foreach ($this->weekdays as $existingWeekday) {
            if ($existingWeekday === $weekday) {
                return true;
            }
        }

        return false;
    }

    public function notContains(Weekday $weekday): bool
    {
        return !$this->contains($weekday);
    }

    /**
     * Collections are equal when they contain the same values, independent of their order.
     */
    public function isEqualTo(self $weekdays): bool
    {
        if (count($this->weekdays) !== count($weekdays->weekdays)) {
            return false;
        }

        foreach ($this->weekdays as $weekday) {
            if ($weekdays->notContains($weekday)) {
                return false;
            }
        }

        return true;
    }

    public function isNotEqualTo(self $weekdays): bool
    {
        return !$this->isEqualTo($weekdays);
    }

    public function first(): ?Weekday
    {
        return $this->weekdays[0] ?? null;
    }

    public function last(): ?Weekday
    {
        $lastKey = array_key_last($this->weekdays);

        return $lastKey !== null
            ? $this->weekdays[$lastKey]
            : null;
    }

    /**
     * @template T
     *
     * @param callable(Weekday): T $mapper
     *
     * @return list<T>
     */
    public function map(callable $mapper): array
    {
        return array_map($mapper, $this->weekdays);
    }

    // -- Mutations

    /**
     * @param callable(Weekday): bool $filter
     */
    public function filter(callable $filter): self
    {
        return new self(array_values(array_filter($this->weekdays, $filter)));
    }

    /**
     * Sorts ascending by default.
     *
     * @param ?callable(Weekday, Weekday): int $comparator
     */
    public function sort(?callable $comparator = null): self
    {
        $weekdays = $this->weekdays;
        usort($weekdays, $comparator ?? static fn (Weekday $a, Weekday $b): int => $a->compareTo($b));

        return new self($weekdays);
    }

    public function min(): ?Weekday
    {
        return $this
            ->sort()
            ->first();
    }

    public function max(): ?Weekday
    {
        return $this
            ->sort()
            ->last();
    }
}
