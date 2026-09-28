<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * @psalm-import-type NormalizedTimeRange from TimeRange
 *
 * @psalm-type NormalizedTimeRanges = list<NormalizedTimeRange>
 *
 * @implements \IteratorAggregate<int, TimeRange>
 */
final readonly class TimeRanges implements ArrayNormalizable, NullableArrayDenormalizable, \Countable, \IteratorAggregate
{
    use NullableArrayDenormalizableTrait;

    /**
     * Values by their unique key for a linear lookup.
     *
     * @var array<int|string, TimeRange>
     */
    private array $keys;

    // -- Construction

    /**
     * @param list<TimeRange> $timeRanges
     *
     * @throws Exception\CollectionContainsDuplicates
     */
    public function __construct(
        /**
         * @var list<TimeRange>
         */
        public array $timeRanges,
    ) {
        $keys = [];
        foreach ($this->timeRanges as $timeRange) {
            $key = serialize([$timeRange->start->format('H:i:s.u'), $timeRange->end->format('H:i:s.u')]);
            if (array_key_exists($key, $keys)) {
                throw new Exception\CollectionContainsDuplicates(self::class);
            }

            $keys[$key] = $timeRange;
        }

        $this->keys = $keys;
    }

    /**
     * Keeps the order in which the values occur first.
     *
     * @param list<TimeRange> $timeRanges
     */
    public static function fromListRemovingDuplicates(array $timeRanges): self
    {
        $uniqueTimeRanges = [];
        foreach ($timeRanges as $timeRange) {
            $uniqueTimeRanges[serialize([$timeRange->start->format('H:i:s.u'), $timeRange->end->format('H:i:s.u')])] = $timeRange;
        }

        return new self(array_values($uniqueTimeRanges));
    }

    // -- Array normalizable

    /**
     * @param NormalizedTimeRanges $data
     */
    #[\Override]
    public static function denormalize(array $data): self
    {
        $timeRanges = [];
        foreach ($data as $value) {
            $timeRanges[] = TimeRange::denormalize($value);
        }

        return new self($timeRanges);
    }

    /**
     * @return NormalizedTimeRanges
     */
    #[\Override]
    public function normalize(): array
    {
        $normalizedTimeRanges = [];
        foreach ($this->timeRanges as $timeRange) {
            $normalizedTimeRanges[] = $timeRange->normalize();
        }

        return $normalizedTimeRanges;
    }

    // -- Countable

    #[\Override]
    public function count(): int
    {
        return count($this->timeRanges);
    }

    // -- IteratorAggregate

    /**
     * @return \Iterator<int, TimeRange>
     */
    #[\Override]
    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->timeRanges);
    }

    // -- Accessors

    public function isEmpty(): bool
    {
        return $this->timeRanges === [];
    }

    public function isNotEmpty(): bool
    {
        return $this->timeRanges !== [];
    }

    public function contains(TimeRange $timeRange): bool
    {
        return array_key_exists(serialize([$timeRange->start->format('H:i:s.u'), $timeRange->end->format('H:i:s.u')]), $this->keys);
    }

    public function notContains(TimeRange $timeRange): bool
    {
        return !$this->contains($timeRange);
    }

    /**
     * Collections are equal when they contain the same values, independent of their order.
     */
    public function isEqualTo(self $timeRanges): bool
    {
        if (count($this->timeRanges) !== count($timeRanges->timeRanges)) {
            return false;
        }

        foreach ($this->timeRanges as $timeRange) {
            if ($timeRanges->notContains($timeRange)) {
                return false;
            }
        }

        return true;
    }

    public function isNotEqualTo(self $timeRanges): bool
    {
        return !$this->isEqualTo($timeRanges);
    }

    public function first(): ?TimeRange
    {
        return $this->timeRanges[0] ?? null;
    }

    public function last(): ?TimeRange
    {
        $lastKey = array_key_last($this->timeRanges);

        return $lastKey !== null
            ? $this->timeRanges[$lastKey]
            : null;
    }

    /**
     * @template T
     *
     * @param callable(TimeRange): T $mapper
     *
     * @return list<T>
     */
    public function map(callable $mapper): array
    {
        return array_map($mapper, $this->timeRanges);
    }

    // -- Mutations

    /**
     * @param callable(TimeRange): bool $filter
     */
    public function filter(callable $filter): self
    {
        return new self(array_values(array_filter($this->timeRanges, $filter)));
    }

    /**
     * @param callable(TimeRange, TimeRange): int $comparator
     */
    public function sort(callable $comparator): self
    {
        $timeRanges = $this->timeRanges;
        usort($timeRanges, $comparator);

        return new self($timeRanges);
    }
}
