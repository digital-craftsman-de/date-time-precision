<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * @psalm-type NormalizedMonths = list<string>
 */
final readonly class Months implements ArrayNormalizable, NullableArrayDenormalizable
{
    use NullableArrayDenormalizableTrait;

    // -- Construction

    /**
     * @param list<Month> $months
     */
    public function __construct(
        /**
         * @var list<Month>
         */
        public array $months,
    ) {
        foreach ($this->months as $index => $month) {
            for ($previousIndex = 0; $previousIndex < $index; ++$previousIndex) {
                if ($this->months[$previousIndex]->isEqualTo($month)) {
                    throw new \InvalidArgumentException('Months must be unique.');
                }
            }
        }
    }

    // -- Array normalizable

    /**
     * @param NormalizedMonths $data
     */
    #[\Override]
    public static function denormalize(array $data): self
    {
        $months = [];
        foreach ($data as $value) {
            $months[] = Month::denormalize($value);
        }

        return new self($months);
    }

    /**
     * @return NormalizedMonths
     */
    #[\Override]
    public function normalize(): array
    {
        $normalizedMonths = [];
        foreach ($this->months as $month) {
            $normalizedMonths[] = $month->normalize();
        }

        return $normalizedMonths;
    }

    // -- Accessors

    public function contains(Month $month): bool
    {
        foreach ($this->months as $existingMonth) {
            if ($existingMonth->isEqualTo($month)) {
                return true;
            }
        }

        return false;
    }

    public function notContains(Month $month): bool
    {
        return !$this->contains($month);
    }
}
