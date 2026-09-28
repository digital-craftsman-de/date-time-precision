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
 */
final readonly class MomentRanges implements ArrayNormalizable, NullableArrayDenormalizable
{
    use NullableArrayDenormalizableTrait;

    // -- Construction

    /**
     * @param list<MomentRange> $momentRanges
     */
    public function __construct(
        /**
         * @var list<MomentRange>
         */
        public array $momentRanges,
    ) {
        foreach ($this->momentRanges as $index => $momentRange) {
            for ($previousIndex = 0; $previousIndex < $index; ++$previousIndex) {
                if ($this->momentRanges[$previousIndex]->isEqualTo($momentRange)) {
                    throw new \InvalidArgumentException('MomentRanges must be unique.');
                }
            }
        }
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

    // -- Accessors

    public function contains(MomentRange $momentRange): bool
    {
        foreach ($this->momentRanges as $existingMomentRange) {
            if ($existingMomentRange->isEqualTo($momentRange)) {
                return true;
            }
        }

        return false;
    }

    public function notContains(MomentRange $momentRange): bool
    {
        return !$this->contains($momentRange);
    }
}
