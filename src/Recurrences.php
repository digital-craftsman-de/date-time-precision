<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * @psalm-import-type NormalizedRecurrence from Recurrence
 *
 * @psalm-type NormalizedRecurrences = list<NormalizedRecurrence>
 *
 * @implements \IteratorAggregate<int, Recurrence>
 */
final readonly class Recurrences implements ArrayNormalizable, NullableArrayDenormalizable, \Countable, \IteratorAggregate
{
    use NullableArrayDenormalizableTrait;

    /**
     * Values by their unique key for a linear lookup.
     *
     * @var array<int|string, Recurrence>
     */
    private array $keys;

    // -- Construction

    /**
     * @param list<Recurrence> $recurrences
     *
     * @throws Exception\CollectionContainsDuplicates
     */
    public function __construct(
        /**
         * @var list<Recurrence>
         */
        public array $recurrences,
    ) {
        $keys = [];
        foreach ($this->recurrences as $recurrence) {
            $key = serialize($recurrence->normalize());
            if (array_key_exists($key, $keys)) {
                throw new Exception\CollectionContainsDuplicates(self::class);
            }

            $keys[$key] = $recurrence;
        }

        $this->keys = $keys;
    }

    /**
     * Keeps the order in which the values occur first.
     *
     * @param list<Recurrence> $recurrences
     */
    public static function fromListRemovingDuplicates(array $recurrences): self
    {
        $uniqueRecurrences = [];
        foreach ($recurrences as $recurrence) {
            $uniqueRecurrences[serialize($recurrence->normalize())] = $recurrence;
        }

        return new self(array_values($uniqueRecurrences));
    }

    // -- Array normalizable

    /**
     * @param NormalizedRecurrences $data
     */
    #[\Override]
    public static function denormalize(array $data): self
    {
        $recurrences = [];
        foreach ($data as $value) {
            $recurrences[] = Recurrence::denormalize($value);
        }

        return new self($recurrences);
    }

    /**
     * @return NormalizedRecurrences
     */
    #[\Override]
    public function normalize(): array
    {
        $normalizedRecurrences = [];
        foreach ($this->recurrences as $recurrence) {
            $normalizedRecurrences[] = $recurrence->normalize();
        }

        return $normalizedRecurrences;
    }

    // -- Countable

    #[\Override]
    public function count(): int
    {
        return count($this->recurrences);
    }

    // -- IteratorAggregate

    /**
     * @return \Iterator<int, Recurrence>
     */
    #[\Override]
    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->recurrences);
    }

    // -- Accessors

    public function isEmpty(): bool
    {
        return $this->recurrences === [];
    }

    public function isNotEmpty(): bool
    {
        return $this->recurrences !== [];
    }

    public function contains(Recurrence $recurrence): bool
    {
        return array_key_exists(serialize($recurrence->normalize()), $this->keys);
    }

    public function notContains(Recurrence $recurrence): bool
    {
        return !$this->contains($recurrence);
    }

    /**
     * Collections are equal when they contain the same values, independent of their order.
     */
    public function isEqualTo(self $recurrences): bool
    {
        if (count($this->recurrences) !== count($recurrences->recurrences)) {
            return false;
        }

        foreach ($this->recurrences as $recurrence) {
            if ($recurrences->notContains($recurrence)) {
                return false;
            }
        }

        return true;
    }

    public function isNotEqualTo(self $recurrences): bool
    {
        return !$this->isEqualTo($recurrences);
    }

    public function first(): ?Recurrence
    {
        return $this->recurrences[0] ?? null;
    }

    public function last(): ?Recurrence
    {
        $lastKey = array_key_last($this->recurrences);

        return $lastKey !== null
            ? $this->recurrences[$lastKey]
            : null;
    }

    /**
     * @template T
     *
     * @param callable(Recurrence): T $mapper
     *
     * @return list<T>
     */
    public function map(callable $mapper): array
    {
        return array_map($mapper, $this->recurrences);
    }

    // -- Mutations

    /**
     * @param callable(Recurrence): bool $filter
     */
    public function filter(callable $filter): self
    {
        return new self(array_values(array_filter($this->recurrences, $filter)));
    }

    /**
     * @param callable(Recurrence, Recurrence): int $comparator
     */
    public function sort(callable $comparator): self
    {
        $recurrences = $this->recurrences;
        usort($recurrences, $comparator);

        return new self($recurrences);
    }
}
