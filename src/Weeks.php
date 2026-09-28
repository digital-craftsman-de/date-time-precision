<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * @psalm-type NormalizedWeeks = list<string>
 *
 * @implements \IteratorAggregate<int, Week>
 */
final readonly class Weeks implements ArrayNormalizable, NullableArrayDenormalizable, \Countable, \IteratorAggregate
{
    use NullableArrayDenormalizableTrait;

    /**
     * Values by their unique key for a linear lookup.
     *
     * @var array<int|string, Week>
     */
    private array $keys;

    // -- Construction

    /**
     * @param list<Week> $weeks
     *
     * @throws Exception\CollectionContainsDuplicates
     */
    public function __construct(
        /**
         * @var list<Week>
         */
        public array $weeks,
    ) {
        $keys = [];
        foreach ($this->weeks as $week) {
            $key = $week->normalize();
            if (array_key_exists($key, $keys)) {
                throw new Exception\CollectionContainsDuplicates(self::class);
            }

            $keys[$key] = $week;
        }

        $this->keys = $keys;
    }

    /**
     * Keeps the order in which the values occur first.
     *
     * @param list<Week> $weeks
     */
    public static function fromListRemovingDuplicates(array $weeks): self
    {
        $uniqueWeeks = [];
        foreach ($weeks as $week) {
            $uniqueWeeks[$week->normalize()] = $week;
        }

        return new self(array_values($uniqueWeeks));
    }

    // -- Array normalizable

    /**
     * @param NormalizedWeeks $data
     */
    #[\Override]
    public static function denormalize(array $data): self
    {
        $weeks = [];
        foreach ($data as $value) {
            $weeks[] = Week::denormalize($value);
        }

        return new self($weeks);
    }

    /**
     * @return NormalizedWeeks
     */
    #[\Override]
    public function normalize(): array
    {
        $normalizedWeeks = [];
        foreach ($this->weeks as $week) {
            $normalizedWeeks[] = $week->normalize();
        }

        return $normalizedWeeks;
    }

    // -- Countable

    #[\Override]
    public function count(): int
    {
        return count($this->weeks);
    }

    // -- IteratorAggregate

    /**
     * @return \Iterator<int, Week>
     */
    #[\Override]
    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->weeks);
    }

    // -- Accessors

    public function isEmpty(): bool
    {
        return $this->weeks === [];
    }

    public function isNotEmpty(): bool
    {
        return $this->weeks !== [];
    }

    public function contains(Week $week): bool
    {
        return array_key_exists($week->normalize(), $this->keys);
    }

    public function notContains(Week $week): bool
    {
        return !$this->contains($week);
    }

    /**
     * Collections are equal when they contain the same values, independent of their order.
     */
    public function isEqualTo(self $weeks): bool
    {
        if (count($this->weeks) !== count($weeks->weeks)) {
            return false;
        }

        foreach ($this->weeks as $week) {
            if ($weeks->notContains($week)) {
                return false;
            }
        }

        return true;
    }

    public function isNotEqualTo(self $weeks): bool
    {
        return !$this->isEqualTo($weeks);
    }

    public function first(): ?Week
    {
        return $this->weeks[0] ?? null;
    }

    public function last(): ?Week
    {
        $lastKey = array_key_last($this->weeks);

        return $lastKey !== null
            ? $this->weeks[$lastKey]
            : null;
    }

    /**
     * @template T
     *
     * @param callable(Week): T $mapper
     *
     * @return list<T>
     */
    public function map(callable $mapper): array
    {
        return array_map($mapper, $this->weeks);
    }

    // -- Mutations

    /**
     * @param callable(Week): bool $filter
     */
    public function filter(callable $filter): self
    {
        return new self(array_values(array_filter($this->weeks, $filter)));
    }

    /**
     * Sorts ascending by default.
     *
     * @param ?callable(Week, Week): int $comparator
     */
    public function sort(?callable $comparator = null): self
    {
        $weeks = $this->weeks;
        usort($weeks, $comparator ?? static fn (Week $a, Week $b): int => $a->compareTo($b));

        return new self($weeks);
    }

    public function min(): ?Week
    {
        return $this
            ->sort()
            ->first();
    }

    public function max(): ?Week
    {
        return $this
            ->sort()
            ->last();
    }
}
