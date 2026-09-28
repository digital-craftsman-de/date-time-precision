<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * @psalm-type NormalizedMoments = list<string>
 */
final readonly class Moments implements ArrayNormalizable, NullableArrayDenormalizable
{
    use NullableArrayDenormalizableTrait;

    // -- Construction

    /**
     * @param list<Moment> $moments
     */
    public function __construct(
        /**
         * @var list<Moment>
         */
        public array $moments,
    ) {
        foreach ($this->moments as $index => $moment) {
            for ($previousIndex = 0; $previousIndex < $index; ++$previousIndex) {
                if ($this->moments[$previousIndex]->isEqualTo($moment)) {
                    throw new \InvalidArgumentException('Moments must be unique.');
                }
            }
        }
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

    // -- Accessors

    public function contains(Moment $moment): bool
    {
        foreach ($this->moments as $existingMoment) {
            if ($existingMoment->isEqualTo($moment)) {
                return true;
            }
        }

        return false;
    }

    public function notContains(Moment $moment): bool
    {
        return !$this->contains($moment);
    }
}
