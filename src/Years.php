<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * @psalm-type NormalizedYears = list<int>
 *
 * @implements \IteratorAggregate<int, Year>
 */
final readonly class Years implements ArrayNormalizable, NullableArrayDenormalizable, \Countable, \IteratorAggregate
{
    use NullableArrayDenormalizableTrait;

    // -- Construction

    /**
     * @param list<Year> $years
     *
     * @throws Exception\CollectionContainsDuplicates
     */
    public function __construct(
        /**
         * @var list<Year>
         */
        public array $years,
    ) {
        foreach ($this->years as $index => $year) {
            for ($previousIndex = 0; $previousIndex < $index; ++$previousIndex) {
                if ($this->years[$previousIndex]->isEqualTo($year)) {
                    throw new Exception\CollectionContainsDuplicates(self::class);
                }
            }
        }
    }

    /**
     * Keeps the first occurrence of every value.
     *
     * @param list<Year> $years
     */
    public static function fromListRemovingDuplicates(array $years): self
    {
        $uniqueYears = [];
        foreach ($years as $year) {
            foreach ($uniqueYears as $uniqueYear) {
                if ($uniqueYear->isEqualTo($year)) {
                    continue 2;
                }
            }

            $uniqueYears[] = $year;
        }

        return new self($uniqueYears);
    }

    // -- Array normalizable

    /**
     * @param NormalizedYears $data
     */
    #[\Override]
    public static function denormalize(array $data): self
    {
        $years = [];
        foreach ($data as $value) {
            $years[] = Year::denormalize($value);
        }

        return new self($years);
    }

    /**
     * @return NormalizedYears
     */
    #[\Override]
    public function normalize(): array
    {
        $normalizedYears = [];
        foreach ($this->years as $year) {
            $normalizedYears[] = $year->normalize();
        }

        return $normalizedYears;
    }

    // -- Countable

    #[\Override]
    public function count(): int
    {
        return count($this->years);
    }

    // -- IteratorAggregate

    /**
     * @return \Iterator<int, Year>
     */
    #[\Override]
    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->years);
    }

    // -- Accessors

    public function isEmpty(): bool
    {
        return $this->years === [];
    }

    public function isNotEmpty(): bool
    {
        return $this->years !== [];
    }

    public function contains(Year $year): bool
    {
        foreach ($this->years as $existingYear) {
            if ($existingYear->isEqualTo($year)) {
                return true;
            }
        }

        return false;
    }

    public function notContains(Year $year): bool
    {
        return !$this->contains($year);
    }

    /**
     * Collections are equal when they contain the same values, independent of their order.
     */
    public function isEqualTo(self $years): bool
    {
        if (count($this->years) !== count($years->years)) {
            return false;
        }

        foreach ($this->years as $year) {
            if ($years->notContains($year)) {
                return false;
            }
        }

        return true;
    }

    public function isNotEqualTo(self $years): bool
    {
        return !$this->isEqualTo($years);
    }

    public function first(): ?Year
    {
        return $this->years[0] ?? null;
    }

    public function last(): ?Year
    {
        $lastKey = array_key_last($this->years);

        return $lastKey !== null
            ? $this->years[$lastKey]
            : null;
    }

    /**
     * @template T
     *
     * @param callable(Year): T $mapper
     *
     * @return list<T>
     */
    public function map(callable $mapper): array
    {
        return array_map($mapper, $this->years);
    }

    // -- Mutations

    /**
     * @param callable(Year): bool $filter
     */
    public function filter(callable $filter): self
    {
        return new self(array_values(array_filter($this->years, $filter)));
    }

    /**
     * Sorts ascending by default.
     *
     * @param ?callable(Year, Year): int $comparator
     */
    public function sort(?callable $comparator = null): self
    {
        $years = $this->years;
        usort($years, $comparator ?? static fn (Year $a, Year $b): int => $a->compareTo($b));

        return new self($years);
    }

    public function min(): ?Year
    {
        return $this
            ->sort()
            ->first();
    }

    public function max(): ?Year
    {
        return $this
            ->sort()
            ->last();
    }
}
