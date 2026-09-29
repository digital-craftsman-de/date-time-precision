<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * @psalm-type NormalizedTimes = list<string>
 *
 * @implements \IteratorAggregate<int, Time>
 */
final readonly class Times implements ArrayNormalizable, NullableArrayDenormalizable, \Countable, \IteratorAggregate
{
    use NullableArrayDenormalizableTrait;

    /**
     * Values by their unique key for a linear lookup.
     *
     * @var array<int|string, Time>
     */
    private array $keys;

    // -- Construction

    /**
     * @param list<Time> $times
     *
     * @throws Exception\CollectionContainsDuplicates
     */
    public function __construct(
        /**
         * @var list<Time>
         */
        public array $times,
    ) {
        $keys = [];
        foreach ($this->times as $time) {
            $key = $time->format('H:i:s.u');
            if (array_key_exists($key, $keys)) {
                throw new Exception\CollectionContainsDuplicates(self::class);
            }

            $keys[$key] = $time;
        }

        $this->keys = $keys;
    }

    /**
     * Keeps the order in which the values occur first.
     *
     * @param list<Time> $times
     */
    public static function fromListRemovingDuplicates(array $times): self
    {
        $uniqueTimes = [];
        foreach ($times as $time) {
            $uniqueTimes[$time->format('H:i:s.u')] = $time;
        }

        return new self(array_values($uniqueTimes));
    }

    // -- Array normalizable

    /**
     * @param NormalizedTimes $data
     */
    #[\Override]
    public static function denormalize(array $data): self
    {
        $times = [];
        foreach ($data as $value) {
            $times[] = Time::denormalize($value);
        }

        return new self($times);
    }

    /**
     * @return NormalizedTimes
     */
    #[\Override]
    public function normalize(): array
    {
        $normalizedTimes = [];
        foreach ($this->times as $time) {
            $normalizedTimes[] = $time->normalize();
        }

        return $normalizedTimes;
    }

    // -- Countable

    #[\Override]
    public function count(): int
    {
        return count($this->times);
    }

    // -- IteratorAggregate

    /**
     * @return \Iterator<int, Time>
     */
    #[\Override]
    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->times);
    }

    // -- Accessors

    public function isEmpty(): bool
    {
        return $this->times === [];
    }

    public function isNotEmpty(): bool
    {
        return $this->times !== [];
    }

    public function contains(Time $time): bool
    {
        return array_key_exists($time->format('H:i:s.u'), $this->keys);
    }

    public function notContains(Time $time): bool
    {
        return !$this->contains($time);
    }

    /**
     * Collections are equal when they contain the same values, independent of their order.
     */
    public function isEqualTo(self $times): bool
    {
        if (count($this->times) !== count($times->times)) {
            return false;
        }

        foreach ($this->times as $time) {
            if ($times->notContains($time)) {
                return false;
            }
        }

        return true;
    }

    public function isNotEqualTo(self $times): bool
    {
        return !$this->isEqualTo($times);
    }

    public function first(): ?Time
    {
        return $this->times[0] ?? null;
    }

    public function last(): ?Time
    {
        $lastKey = array_key_last($this->times);

        return $lastKey !== null
            ? $this->times[$lastKey]
            : null;
    }

    /**
     * @template T
     *
     * @param callable(Time): T $mapper
     *
     * @return list<T>
     */
    public function map(callable $mapper): array
    {
        return array_map($mapper, $this->times);
    }

    // -- Mutations

    /**
     * @param callable(Time): bool $filter
     */
    public function filter(callable $filter): self
    {
        return new self(array_values(array_filter($this->times, $filter)));
    }

    /**
     * Sorts ascending by default.
     *
     * @param ?callable(Time, Time): int $comparator
     */
    public function sort(?callable $comparator = null): self
    {
        $times = $this->times;
        usort($times, $comparator ?? static fn (Time $a, Time $b): int => $a->compareTo($b));

        return new self($times);
    }

    public function min(): ?Time
    {
        return $this
            ->sort()
            ->first();
    }

    public function max(): ?Time
    {
        return $this
            ->sort()
            ->last();
    }
}
