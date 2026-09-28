<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * @psalm-type NormalizedDates = list<string>
 *
 * @implements \IteratorAggregate<int, Date>
 */
final readonly class Dates implements ArrayNormalizable, NullableArrayDenormalizable, \Countable, \IteratorAggregate
{
    use NullableArrayDenormalizableTrait;

    /**
     * Values by their unique key for a linear lookup.
     *
     * @var array<int|string, Date>
     */
    private array $keys;

    // -- Construction

    /**
     * @param list<Date> $dates
     *
     * @throws Exception\CollectionContainsDuplicates
     */
    public function __construct(
        /**
         * @var list<Date>
         */
        public array $dates,
    ) {
        $keys = [];
        foreach ($this->dates as $date) {
            $key = $date->normalize();
            if (array_key_exists($key, $keys)) {
                throw new Exception\CollectionContainsDuplicates(self::class);
            }

            $keys[$key] = $date;
        }

        $this->keys = $keys;
    }

    /**
     * Keeps the order in which the values occur first.
     *
     * @param list<Date> $dates
     */
    public static function fromListRemovingDuplicates(array $dates): self
    {
        $uniqueDates = [];
        foreach ($dates as $date) {
            $uniqueDates[$date->normalize()] = $date;
        }

        return new self(array_values($uniqueDates));
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

    // -- Countable

    #[\Override]
    public function count(): int
    {
        return count($this->dates);
    }

    // -- IteratorAggregate

    /**
     * @return \Iterator<int, Date>
     */
    #[\Override]
    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->dates);
    }

    // -- Accessors

    public function isEmpty(): bool
    {
        return $this->dates === [];
    }

    public function isNotEmpty(): bool
    {
        return $this->dates !== [];
    }

    public function contains(Date $date): bool
    {
        return array_key_exists($date->normalize(), $this->keys);
    }

    public function notContains(Date $date): bool
    {
        return !$this->contains($date);
    }

    /**
     * Collections are equal when they contain the same values, independent of their order.
     */
    public function isEqualTo(self $dates): bool
    {
        if (count($this->dates) !== count($dates->dates)) {
            return false;
        }

        foreach ($this->dates as $date) {
            if ($dates->notContains($date)) {
                return false;
            }
        }

        return true;
    }

    public function isNotEqualTo(self $dates): bool
    {
        return !$this->isEqualTo($dates);
    }

    public function first(): ?Date
    {
        return $this->dates[0] ?? null;
    }

    public function last(): ?Date
    {
        $lastKey = array_key_last($this->dates);

        return $lastKey !== null
            ? $this->dates[$lastKey]
            : null;
    }

    /**
     * @template T
     *
     * @param callable(Date): T $mapper
     *
     * @return list<T>
     */
    public function map(callable $mapper): array
    {
        return array_map($mapper, $this->dates);
    }

    // -- Mutations

    /**
     * @param callable(Date): bool $filter
     */
    public function filter(callable $filter): self
    {
        return new self(array_values(array_filter($this->dates, $filter)));
    }

    /**
     * Sorts ascending by default.
     *
     * @param ?callable(Date, Date): int $comparator
     */
    public function sort(?callable $comparator = null): self
    {
        $dates = $this->dates;
        usort($dates, $comparator ?? static fn (Date $a, Date $b): int => $a->compareTo($b));

        return new self($dates);
    }

    public function min(): ?Date
    {
        return $this
            ->sort()
            ->first();
    }

    public function max(): ?Date
    {
        return $this
            ->sort()
            ->last();
    }
}
