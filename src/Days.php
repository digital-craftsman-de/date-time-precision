<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * @psalm-type NormalizedDays = list<int>
 *
 * @implements \IteratorAggregate<int, Day>
 */
final readonly class Days implements ArrayNormalizable, NullableArrayDenormalizable, \Countable, \IteratorAggregate
{
    use NullableArrayDenormalizableTrait;

    /**
     * Values by their unique key for a linear lookup.
     *
     * @var array<int|string, Day>
     */
    private array $keys;

    // -- Construction

    /**
     * @param list<Day> $days
     *
     * @throws Exception\CollectionContainsDuplicates
     */
    public function __construct(
        /**
         * @var list<Day>
         */
        public array $days,
    ) {
        $keys = [];
        foreach ($this->days as $day) {
            $key = $day->day;
            if (array_key_exists($key, $keys)) {
                throw new Exception\CollectionContainsDuplicates(self::class);
            }

            $keys[$key] = $day;
        }

        $this->keys = $keys;
    }

    /**
     * Keeps the order in which the values occur first.
     *
     * @param list<Day> $days
     */
    public static function fromListRemovingDuplicates(array $days): self
    {
        $uniqueDays = [];
        foreach ($days as $day) {
            $uniqueDays[$day->day] = $day;
        }

        return new self(array_values($uniqueDays));
    }

    // -- Array normalizable

    /**
     * @param NormalizedDays $data
     */
    #[\Override]
    public static function denormalize(array $data): self
    {
        $days = [];
        foreach ($data as $value) {
            $days[] = Day::denormalize($value);
        }

        return new self($days);
    }

    /**
     * @return NormalizedDays
     */
    #[\Override]
    public function normalize(): array
    {
        $normalizedDays = [];
        foreach ($this->days as $day) {
            $normalizedDays[] = $day->normalize();
        }

        return $normalizedDays;
    }

    // -- Countable

    #[\Override]
    public function count(): int
    {
        return count($this->days);
    }

    // -- IteratorAggregate

    /**
     * @return \Iterator<int, Day>
     */
    #[\Override]
    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->days);
    }

    // -- Accessors

    public function isEmpty(): bool
    {
        return $this->days === [];
    }

    public function isNotEmpty(): bool
    {
        return $this->days !== [];
    }

    public function contains(Day $day): bool
    {
        return array_key_exists($day->day, $this->keys);
    }

    public function notContains(Day $day): bool
    {
        return !$this->contains($day);
    }

    /**
     * Collections are equal when they contain the same values, independent of their order.
     */
    public function isEqualTo(self $days): bool
    {
        if (count($this->days) !== count($days->days)) {
            return false;
        }

        foreach ($this->days as $day) {
            if ($days->notContains($day)) {
                return false;
            }
        }

        return true;
    }

    public function isNotEqualTo(self $days): bool
    {
        return !$this->isEqualTo($days);
    }

    public function first(): ?Day
    {
        return $this->days[0] ?? null;
    }

    public function last(): ?Day
    {
        $lastKey = array_key_last($this->days);

        return $lastKey !== null
            ? $this->days[$lastKey]
            : null;
    }

    /**
     * @template T
     *
     * @param callable(Day): T $mapper
     *
     * @return list<T>
     */
    public function map(callable $mapper): array
    {
        return array_map($mapper, $this->days);
    }

    // -- Mutations

    /**
     * @param callable(Day): bool $filter
     */
    public function filter(callable $filter): self
    {
        return new self(array_values(array_filter($this->days, $filter)));
    }

    /**
     * Sorts ascending by default.
     *
     * @param ?callable(Day, Day): int $comparator
     */
    public function sort(?callable $comparator = null): self
    {
        $days = $this->days;
        usort($days, $comparator ?? static fn (Day $a, Day $b): int => $a->day <=> $b->day);

        return new self($days);
    }

    public function min(): ?Day
    {
        return $this
            ->sort()
            ->first();
    }

    public function max(): ?Day
    {
        return $this
            ->sort()
            ->last();
    }
}
