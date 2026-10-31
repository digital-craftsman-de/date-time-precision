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

    /**
     * Values by their unique key for a linear lookup.
     *
     * @var array<int|string, Year>
     */
    private array $keys;

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
        $keys = [];
        foreach ($this->years as $year) {
            $key = $year->year;
            if (array_key_exists($key, $keys)) {
                throw new Exception\CollectionContainsDuplicates(self::class);
            }

            $keys[$key] = $year;
        }

        $this->keys = $keys;
    }

    /**
     * Keeps the order in which the values occur first.
     *
     * @param list<Year> $years
     */
    public static function fromListRemovingDuplicates(array $years): self
    {
        $uniqueYears = [];
        foreach ($years as $year) {
            $uniqueYears[$year->year] = $year;
        }

        return new self(array_values($uniqueYears));
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
        return array_key_exists($year->year, $this->keys);
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
        return array_first($this->years);
    }

    public function last(): ?Year
    {
        return array_last($this->years);
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
    #[\NoDiscard('as Years is immutable')]
    public function filter(callable $filter): self
    {
        return new self(array_values(array_filter($this->years, $filter)));
    }

    /**
     * Sorts ascending by default.
     *
     * @param ?callable(Year, Year): int $comparator
     */
    #[\NoDiscard('as Years is immutable')]
    public function sort(?callable $comparator = null): self
    {
        $years = $this->years;
        usort($years, $comparator ?? static fn (Year $a, Year $b): int => $a->compareTo($b));

        return new self($years);
    }

    public function min(): ?Year
    {
        $min = null;
        foreach ($this->years as $year) {
            if ($min === null
                || $year->isBefore($min)
            ) {
                $min = $year;
            }
        }

        return $min;
    }

    public function max(): ?Year
    {
        $max = null;
        foreach ($this->years as $year) {
            if ($max === null
                || $year->isAfter($max)
            ) {
                $max = $year;
            }
        }

        return $max;
    }
}
