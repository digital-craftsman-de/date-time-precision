<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * @psalm-type NormalizedMonths = list<string>
 *
 * @implements \IteratorAggregate<int, Month>
 */
final readonly class Months implements ArrayNormalizable, NullableArrayDenormalizable, \Countable, \IteratorAggregate
{
    use NullableArrayDenormalizableTrait;

    // -- Construction

    /**
     * @param list<Month> $months
     *
     * @throws Exception\CollectionContainsDuplicates
     */
    public function __construct(
        /**
         * @var list<Month>
         */
        public array $months,
    ) {
        foreach ($this->months as $index => $month) {
            for ($previousIndex = 0; $previousIndex < $index; ++$previousIndex) {
                if ($this->months[$previousIndex]->isEqualTo($month)) {
                    throw new Exception\CollectionContainsDuplicates(self::class);
                }
            }
        }
    }

    /**
     * Keeps the first occurrence of every value.
     *
     * @param list<Month> $months
     */
    public static function fromListRemovingDuplicates(array $months): self
    {
        $uniqueMonths = [];
        foreach ($months as $month) {
            foreach ($uniqueMonths as $uniqueMonth) {
                if ($uniqueMonth->isEqualTo($month)) {
                    continue 2;
                }
            }

            $uniqueMonths[] = $month;
        }

        return new self($uniqueMonths);
    }

    // -- Array normalizable

    /**
     * @param NormalizedMonths $data
     */
    #[\Override]
    public static function denormalize(array $data): self
    {
        $months = [];
        foreach ($data as $value) {
            $months[] = Month::denormalize($value);
        }

        return new self($months);
    }

    /**
     * @return NormalizedMonths
     */
    #[\Override]
    public function normalize(): array
    {
        $normalizedMonths = [];
        foreach ($this->months as $month) {
            $normalizedMonths[] = $month->normalize();
        }

        return $normalizedMonths;
    }

    // -- Countable

    #[\Override]
    public function count(): int
    {
        return count($this->months);
    }

    // -- IteratorAggregate

    /**
     * @return \Iterator<int, Month>
     */
    #[\Override]
    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->months);
    }

    // -- Accessors

    public function isEmpty(): bool
    {
        return $this->months === [];
    }

    public function isNotEmpty(): bool
    {
        return $this->months !== [];
    }

    public function contains(Month $month): bool
    {
        foreach ($this->months as $existingMonth) {
            if ($existingMonth->isEqualTo($month)) {
                return true;
            }
        }

        return false;
    }

    public function notContains(Month $month): bool
    {
        return !$this->contains($month);
    }

    /**
     * Collections are equal when they contain the same values, independent of their order.
     */
    public function isEqualTo(self $months): bool
    {
        if (count($this->months) !== count($months->months)) {
            return false;
        }

        foreach ($this->months as $month) {
            if ($months->notContains($month)) {
                return false;
            }
        }

        return true;
    }

    public function isNotEqualTo(self $months): bool
    {
        return !$this->isEqualTo($months);
    }

    public function first(): ?Month
    {
        return $this->months[0] ?? null;
    }

    public function last(): ?Month
    {
        $lastKey = array_key_last($this->months);

        return $lastKey !== null
            ? $this->months[$lastKey]
            : null;
    }

    /**
     * @template T
     *
     * @param callable(Month): T $mapper
     *
     * @return list<T>
     */
    public function map(callable $mapper): array
    {
        return array_map($mapper, $this->months);
    }

    // -- Mutations

    /**
     * @param callable(Month): bool $filter
     */
    public function filter(callable $filter): self
    {
        return new self(array_values(array_filter($this->months, $filter)));
    }

    /**
     * Sorts ascending by default.
     *
     * @param ?callable(Month, Month): int $comparator
     */
    public function sort(?callable $comparator = null): self
    {
        $months = $this->months;
        usort($months, $comparator ?? static fn (Month $a, Month $b): int => $a->compareTo($b));

        return new self($months);
    }

    public function min(): ?Month
    {
        return $this
            ->sort()
            ->first();
    }

    public function max(): ?Month
    {
        return $this
            ->sort()
            ->last();
    }
}
