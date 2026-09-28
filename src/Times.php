<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * @psalm-type NormalizedTimes = list<string>
 */
final readonly class Times implements ArrayNormalizable, NullableArrayDenormalizable
{
    use NullableArrayDenormalizableTrait;

    // -- Construction

    /**
     * @param list<Time> $times
     */
    public function __construct(
        /**
         * @var list<Time>
         */
        public array $times,
    ) {
        foreach ($this->times as $index => $time) {
            for ($previousIndex = 0; $previousIndex < $index; ++$previousIndex) {
                if ($this->times[$previousIndex]->isEqualTo($time)) {
                    throw new \InvalidArgumentException('Times must be unique.');
                }
            }
        }
    }

    // -- Array normalizable

    /**
     * @param NormalizedTimes $data
     */
    #[\Override]
    public static function denormalize(array $data): self
    {
        $times = [];
        foreach ($data as $value) {
            $times[] = Time::denormalize($value);
        }

        return new self($times);
    }

    /**
     * @return NormalizedTimes
     */
    #[\Override]
    public function normalize(): array
    {
        $normalizedTimes = [];
        foreach ($this->times as $time) {
            $normalizedTimes[] = $time->normalize();
        }

        return $normalizedTimes;
    }

    // -- Accessors

    public function contains(Time $time): bool
    {
        foreach ($this->times as $existingTime) {
            if ($existingTime->isEqualTo($time)) {
                return true;
            }
        }

        return false;
    }

    public function notContains(Time $time): bool
    {
        return !$this->contains($time);
    }
}
