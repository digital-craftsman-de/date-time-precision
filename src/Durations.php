<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * @psalm-type NormalizedDurations = list<int>
 *
 * @implements \IteratorAggregate<int, Duration>
 */
final readonly class Durations implements ArrayNormalizable, NullableArrayDenormalizable, \Countable, \IteratorAggregate
{
    use NullableArrayDenormalizableTrait;

    // -- Construction

    /**
     * @param list<Duration> $durations
     *
     * @throws Exception\CollectionContainsDuplicates
     */
    public function __construct(
        /**
         * @var list<Duration>
         */
        public array $durations,
    ) {
        foreach ($this->durations as $index => $duration) {
            for ($previousIndex = 0; $previousIndex < $index; ++$previousIndex) {
                if ($this->durations[$previousIndex]->isEqualTo($duration)) {
                    throw new Exception\CollectionContainsDuplicates(self::class);
                }
            }
        }
    }

    /**
     * Keeps the first occurrence of every value.
     *
     * @param list<Duration> $durations
     */
    public static function fromListRemovingDuplicates(array $durations): self
    {
        $uniqueDurations = [];
        foreach ($durations as $duration) {
            foreach ($uniqueDurations as $uniqueDuration) {
                if ($uniqueDuration->isEqualTo($duration)) {
                    continue 2;
                }
            }

            $uniqueDurations[] = $duration;
        }

        return new self($uniqueDurations);
    }

    // -- Array normalizable

    /**
     * @param NormalizedDurations $data
     */
    #[\Override]
    public static function denormalize(array $data): self
    {
        $durations = [];
        foreach ($data as $value) {
            $durations[] = Duration::denormalize($value);
        }

        return new self($durations);
    }

    /**
     * @return NormalizedDurations
     */
    #[\Override]
    public function normalize(): array
    {
        $normalizedDurations = [];
        foreach ($this->durations as $duration) {
            $normalizedDurations[] = $duration->normalize();
        }

        return $normalizedDurations;
    }

    // -- Countable

    #[\Override]
    public function count(): int
    {
        return count($this->durations);
    }

    // -- IteratorAggregate

    /**
     * @return \Iterator<int, Duration>
     */
    #[\Override]
    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->durations);
    }

    // -- Accessors

    public function isEmpty(): bool
    {
        return $this->durations === [];
    }

    public function isNotEmpty(): bool
    {
        return $this->durations !== [];
    }

    public function contains(Duration $duration): bool
    {
        foreach ($this->durations as $existingDuration) {
            if ($existingDuration->isEqualTo($duration)) {
                return true;
            }
        }

        return false;
    }

    public function notContains(Duration $duration): bool
    {
        return !$this->contains($duration);
    }

    /**
     * Collections are equal when they contain the same values, independent of their order.
     */
    public function isEqualTo(self $durations): bool
    {
        if (count($this->durations) !== count($durations->durations)) {
            return false;
        }

        foreach ($this->durations as $duration) {
            if ($durations->notContains($duration)) {
                return false;
            }
        }

        return true;
    }

    public function isNotEqualTo(self $durations): bool
    {
        return !$this->isEqualTo($durations);
    }

    public function first(): ?Duration
    {
        return $this->durations[0] ?? null;
    }

    public function last(): ?Duration
    {
        $lastKey = array_key_last($this->durations);

        return $lastKey !== null
            ? $this->durations[$lastKey]
            : null;
    }

    /**
     * @template T
     *
     * @param callable(Duration): T $mapper
     *
     * @return list<T>
     */
    public function map(callable $mapper): array
    {
        return array_map($mapper, $this->durations);
    }

    // -- Mutations

    /**
     * @param callable(Duration): bool $filter
     */
    public function filter(callable $filter): self
    {
        return new self(array_values(array_filter($this->durations, $filter)));
    }

    /**
     * Sorts ascending by default.
     *
     * @param ?callable(Duration, Duration): int $comparator
     */
    public function sort(?callable $comparator = null): self
    {
        $durations = $this->durations;
        usort($durations, $comparator ?? static fn (Duration $a, Duration $b): int => $a->compareTo($b));

        return new self($durations);
    }

    public function min(): ?Duration
    {
        return $this
            ->sort()
            ->first();
    }

    public function max(): ?Duration
    {
        return $this
            ->sort()
            ->last();
    }
}
