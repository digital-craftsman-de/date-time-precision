<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * @psalm-type NormalizedMoments = list<string>
 *
 * @implements \IteratorAggregate<int, Moment>
 */
final readonly class Moments implements ArrayNormalizable, NullableArrayDenormalizable, \Countable, \IteratorAggregate
{
    use NullableArrayDenormalizableTrait;

    /**
     * Values by their unique key for a linear lookup.
     *
     * @var array<int|string, Moment>
     */
    private array $keys;

    // -- Construction

    /**
     * @param list<Moment> $moments
     *
     * @throws Exception\CollectionContainsDuplicates
     */
    public function __construct(
        /**
         * @var list<Moment>
         */
        public array $moments,
    ) {
        $keys = [];
        foreach ($this->moments as $moment) {
            $key = $moment->normalize();
            if (array_key_exists($key, $keys)) {
                throw new Exception\CollectionContainsDuplicates(self::class);
            }

            $keys[$key] = $moment;
        }

        $this->keys = $keys;
    }

    /**
     * Keeps the order in which the values occur first.
     *
     * @param list<Moment> $moments
     */
    public static function fromListRemovingDuplicates(array $moments): self
    {
        $uniqueMoments = [];
        foreach ($moments as $moment) {
            $uniqueMoments[$moment->normalize()] = $moment;
        }

        return new self(array_values($uniqueMoments));
    }

    // -- Array normalizable

    /**
     * @param NormalizedMoments $data
     */
    #[\Override]
    public static function denormalize(array $data): self
    {
        $moments = [];
        foreach ($data as $value) {
            $moments[] = Moment::denormalize($value);
        }

        return new self($moments);
    }

    /**
     * @return NormalizedMoments
     */
    #[\Override]
    public function normalize(): array
    {
        $normalizedMoments = [];
        foreach ($this->moments as $moment) {
            $normalizedMoments[] = $moment->normalize();
        }

        return $normalizedMoments;
    }

    // -- Countable

    #[\Override]
    public function count(): int
    {
        return count($this->moments);
    }

    // -- IteratorAggregate

    /**
     * @return \Iterator<int, Moment>
     */
    #[\Override]
    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->moments);
    }

    // -- Accessors

    public function isEmpty(): bool
    {
        return $this->moments === [];
    }

    public function isNotEmpty(): bool
    {
        return $this->moments !== [];
    }

    public function contains(Moment $moment): bool
    {
        return array_key_exists($moment->normalize(), $this->keys);
    }

    public function notContains(Moment $moment): bool
    {
        return !$this->contains($moment);
    }

    /**
     * Collections are equal when they contain the same values, independent of their order.
     */
    public function isEqualTo(self $moments): bool
    {
        if (count($this->moments) !== count($moments->moments)) {
            return false;
        }

        foreach ($this->moments as $moment) {
            if ($moments->notContains($moment)) {
                return false;
            }
        }

        return true;
    }

    public function isNotEqualTo(self $moments): bool
    {
        return !$this->isEqualTo($moments);
    }

    public function first(): ?Moment
    {
        return $this->moments[0] ?? null;
    }

    public function last(): ?Moment
    {
        $lastKey = array_key_last($this->moments);

        return $lastKey !== null
            ? $this->moments[$lastKey]
            : null;
    }

    /**
     * @template T
     *
     * @param callable(Moment): T $mapper
     *
     * @return list<T>
     */
    public function map(callable $mapper): array
    {
        return array_map($mapper, $this->moments);
    }

    // -- Mutations

    /**
     * @param callable(Moment): bool $filter
     */
    public function filter(callable $filter): self
    {
        return new self(array_values(array_filter($this->moments, $filter)));
    }

    /**
     * Sorts ascending by default.
     *
     * @param ?callable(Moment, Moment): int $comparator
     */
    public function sort(?callable $comparator = null): self
    {
        $moments = $this->moments;
        usort($moments, $comparator ?? static fn (Moment $a, Moment $b): int => $a->compareTo($b));

        return new self($moments);
    }

    public function min(): ?Moment
    {
        return $this
            ->sort()
            ->first();
    }

    public function max(): ?Moment
    {
        return $this
            ->sort()
            ->last();
    }
}
