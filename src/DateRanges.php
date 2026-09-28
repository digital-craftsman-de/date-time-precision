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
 */
final readonly class DateRanges implements ArrayNormalizable, NullableArrayDenormalizable
{
    use NullableArrayDenormalizableTrait;

    // -- Construction

    /**
     * @param list<DateRange> $dateRanges
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
                    throw new \InvalidArgumentException('DateRanges must be unique.');
                }
            }
        }
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

    // -- Accessors

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
}
