<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * @psalm-type NormalizedYears = list<int>
 */
final readonly class Years implements ArrayNormalizable, NullableArrayDenormalizable
{
    use NullableArrayDenormalizableTrait;

    // -- Construction

    /**
     * @param list<Year> $years
     */
    public function __construct(
        /**
         * @var list<Year>
         */
        public array $years,
    ) {
        foreach ($this->years as $index => $year) {
            for ($previousIndex = 0; $previousIndex < $index; ++$previousIndex) {
                if ($this->years[$previousIndex]->isEqualTo($year)) {
                    throw new \InvalidArgumentException('Years must be unique.');
                }
            }
        }
    }

    // -- Array normalizable

    /**
     * @param NormalizedYears $data
     */
    #[\Override]
    public static function denormalize(array $data): self
    {
        $years = [];
        foreach ($data as $value) {
            $years[] = Year::denormalize($value);
        }

        return new self($years);
    }

    /**
     * @return NormalizedYears
     */
    #[\Override]
    public function normalize(): array
    {
        $normalizedYears = [];
        foreach ($this->years as $year) {
            $normalizedYears[] = $year->normalize();
        }

        return $normalizedYears;
    }

    // -- Accessors

    public function contains(Year $year): bool
    {
        foreach ($this->years as $existingYear) {
            if ($existingYear->isEqualTo($year)) {
                return true;
            }
        }

        return false;
    }

    public function notContains(Year $year): bool
    {
        return !$this->contains($year);
    }
}
