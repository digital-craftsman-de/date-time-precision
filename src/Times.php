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
        foreach ($this->times as $index => $time) {
            for ($previousIndex = 0; $previousIndex < $index; ++$previousIndex) {
                if ($this->times[$previousIndex]->isEqualTo($time)) {
                    throw new Exception\CollectionContainsDuplicates(self::class);
                }
            }
        }
    }

    /**
     * Keeps the first occurrence of every value.
     *
     * @param list<Time> $times
     */
    public static function fromListRemovingDuplicates(array $times): self
    {
        $uniqueTimes = [];
        foreach ($times as $time) {
            foreach ($uniqueTimes as $uniqueTime) {
                if ($uniqueTime->isEqualTo($time)) {
                    continue 2;
                }
            }

            $uniqueTimes[] = $time;
        }

        return new self($uniqueTimes);
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
        foreach ($this->times as $existingTime) {
            if ($existingTime->isEqualTo($time)) {
                return true;
            }
        }

        return false;
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
