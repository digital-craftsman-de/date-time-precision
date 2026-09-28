<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * @psalm-import-type NormalizedDateRange from DateRange
 *
 * @psalm-type NormalizedDateRanges = list<NormalizedDateRange>
 *
 * @implements \IteratorAggregate<int, DateRange>
 */
final readonly class DateRanges implements ArrayNormalizable, NullableArrayDenormalizable, \Countable, \IteratorAggregate
{
    use NullableArrayDenormalizableTrait;

    // -- Construction

    /**
     * @param list<DateRange> $dateRanges
     *
     * @throws Exception\CollectionContainsDuplicates
     */
    public function __construct(
        /**
         * @var list<DateRange>
         */
        public array $dateRanges,
    ) {
        foreach ($this->dateRanges as $index => $dateRange) {
            for ($previousIndex = 0; $previousIndex < $index; ++$previousIndex) {
                if ($this->dateRanges[$previousIndex]->isEqualTo($dateRange)) {
                    throw new Exception\CollectionContainsDuplicates(self::class);
                }
            }
        }
    }

    /**
     * Keeps the first occurrence of every value.
     *
     * @param list<DateRange> $dateRanges
     */
    public static function fromListRemovingDuplicates(array $dateRanges): self
    {
        $uniqueDateRanges = [];
        foreach ($dateRanges as $dateRange) {
            foreach ($uniqueDateRanges as $uniqueDateRange) {
                if ($uniqueDateRange->isEqualTo($dateRange)) {
                    continue 2;
                }
            }

            $uniqueDateRanges[] = $dateRange;
        }

        return new self($uniqueDateRanges);
    }

    // -- Array normalizable

    /**
     * @param NormalizedDateRanges $data
     */
    #[\Override]
    public static function denormalize(array $data): self
    {
        $dateRanges = [];
        foreach ($data as $value) {
            $dateRanges[] = DateRange::denormalize($value);
        }

        return new self($dateRanges);
    }

    /**
     * @return NormalizedDateRanges
     */
    #[\Override]
    public function normalize(): array
    {
        $normalizedDateRanges = [];
        foreach ($this->dateRanges as $dateRange) {
            $normalizedDateRanges[] = $dateRange->normalize();
        }

        return $normalizedDateRanges;
    }

    // -- Countable

    #[\Override]
    public function count(): int
    {
        return count($this->dateRanges);
    }

    // -- IteratorAggregate

    /**
     * @return \Iterator<int, DateRange>
     */
    #[\Override]
    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->dateRanges);
    }

    // -- Accessors

    public function isEmpty(): bool
    {
        return $this->dateRanges === [];
    }

    public function isNotEmpty(): bool
    {
        return $this->dateRanges !== [];
    }

    public function contains(DateRange $dateRange): bool
    {
        foreach ($this->dateRanges as $existingDateRange) {
            if ($existingDateRange->isEqualTo($dateRange)) {
                return true;
            }
        }

        return false;
    }

    public function notContains(DateRange $dateRange): bool
    {
        return !$this->contains($dateRange);
    }

    /**
     * Collections are equal when they contain the same values, independent of their order.
     */
    public function isEqualTo(self $dateRanges): bool
    {
        if (count($this->dateRanges) !== count($dateRanges->dateRanges)) {
            return false;
        }

        foreach ($this->dateRanges as $dateRange) {
            if ($dateRanges->notContains($dateRange)) {
                return false;
            }
        }

        return true;
    }

    public function isNotEqualTo(self $dateRanges): bool
    {
        return !$this->isEqualTo($dateRanges);
    }

    public function first(): ?DateRange
    {
        return $this->dateRanges[0] ?? null;
    }

    public function last(): ?DateRange
    {
        $lastKey = array_key_last($this->dateRanges);

        return $lastKey !== null
            ? $this->dateRanges[$lastKey]
            : null;
    }

    /**
     * @template T
     *
     * @param callable(DateRange): T $mapper
     *
     * @return list<T>
     */
    public function map(callable $mapper): array
    {
        return array_map($mapper, $this->dateRanges);
    }

    // -- Mutations

    /**
     * @param callable(DateRange): bool $filter
     */
    public function filter(callable $filter): self
    {
        return new self(array_values(array_filter($this->dateRanges, $filter)));
    }

    /**
     * @param callable(DateRange, DateRange): int $comparator
     */
    public function sort(callable $comparator): self
    {
        $dateRanges = $this->dateRanges;
        usort($dateRanges, $comparator);

        return new self($dateRanges);
    }
}
