<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * @psalm-import-type NormalizedMomentRange from MomentRange
 *
 * @psalm-type NormalizedMomentRanges = list<NormalizedMomentRange>
 *
 * @implements \IteratorAggregate<int, MomentRange>
 */
final readonly class MomentRanges implements ArrayNormalizable, NullableArrayDenormalizable, \Countable, \IteratorAggregate
{
    use NullableArrayDenormalizableTrait;

    /**
     * Values by their unique key for a linear lookup.
     *
     * @var array<int|string, MomentRange>
     */
    private array $keys;

    // -- Construction

    /**
     * @param list<MomentRange> $momentRanges
     *
     * @throws Exception\CollectionContainsDuplicates
     */
    public function __construct(
        /**
         * @var list<MomentRange>
         */
        public array $momentRanges,
    ) {
        $keys = [];
        foreach ($this->momentRanges as $momentRange) {
            $key = serialize($momentRange->normalize());
            if (array_key_exists($key, $keys)) {
                throw new Exception\CollectionContainsDuplicates(self::class);
            }

            $keys[$key] = $momentRange;
        }

        $this->keys = $keys;
    }

    /**
     * Keeps the order in which the values occur first.
     *
     * @param list<MomentRange> $momentRanges
     */
    public static function fromListRemovingDuplicates(array $momentRanges): self
    {
        $uniqueMomentRanges = [];
        foreach ($momentRanges as $momentRange) {
            $uniqueMomentRanges[serialize($momentRange->normalize())] = $momentRange;
        }

        return new self(array_values($uniqueMomentRanges));
    }

    // -- Array normalizable

    /**
     * @param NormalizedMomentRanges $data
     */
    #[\Override]
    public static function denormalize(array $data): self
    {
        $momentRanges = [];
        foreach ($data as $value) {
            $momentRanges[] = MomentRange::denormalize($value);
        }

        return new self($momentRanges);
    }

    /**
     * @return NormalizedMomentRanges
     */
    #[\Override]
    public function normalize(): array
    {
        $normalizedMomentRanges = [];
        foreach ($this->momentRanges as $momentRange) {
            $normalizedMomentRanges[] = $momentRange->normalize();
        }

        return $normalizedMomentRanges;
    }

    // -- Countable

    #[\Override]
    public function count(): int
    {
        return count($this->momentRanges);
    }

    // -- IteratorAggregate

    /**
     * @return \Iterator<int, MomentRange>
     */
    #[\Override]
    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->momentRanges);
    }

    // -- Accessors

    public function isEmpty(): bool
    {
        return $this->momentRanges === [];
    }

    public function isNotEmpty(): bool
    {
        return $this->momentRanges !== [];
    }

    public function contains(MomentRange $momentRange): bool
    {
        return array_key_exists(serialize($momentRange->normalize()), $this->keys);
    }

    public function notContains(MomentRange $momentRange): bool
    {
        return !$this->contains($momentRange);
    }

    /**
     * Collections are equal when they contain the same values, independent of their order.
     */
    public function isEqualTo(self $momentRanges): bool
    {
        if (count($this->momentRanges) !== count($momentRanges->momentRanges)) {
            return false;
        }

        foreach ($this->momentRanges as $momentRange) {
            if ($momentRanges->notContains($momentRange)) {
                return false;
            }
        }

        return true;
    }

    public function isNotEqualTo(self $momentRanges): bool
    {
        return !$this->isEqualTo($momentRanges);
    }

    public function first(): ?MomentRange
    {
        return $this->momentRanges[0] ?? null;
    }

    public function last(): ?MomentRange
    {
        $lastKey = array_key_last($this->momentRanges);

        return $lastKey !== null
            ? $this->momentRanges[$lastKey]
            : null;
    }

    /**
     * @template T
     *
     * @param callable(MomentRange): T $mapper
     *
     * @return list<T>
     */
    public function map(callable $mapper): array
    {
        return array_map($mapper, $this->momentRanges);
    }

    // -- Mutations

    /**
     * @param callable(MomentRange): bool $filter
     */
    public function filter(callable $filter): self
    {
        return new self(array_values(array_filter($this->momentRanges, $filter)));
    }

    /**
     * @param callable(MomentRange, MomentRange): int $comparator
     */
    public function sort(callable $comparator): self
    {
        $momentRanges = $this->momentRanges;
        usort($momentRanges, $comparator);

        return new self($momentRanges);
    }
}
