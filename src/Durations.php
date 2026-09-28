<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * @psalm-type NormalizedDurations = list<int>
 */
final readonly class Durations implements ArrayNormalizable, NullableArrayDenormalizable
{
    use NullableArrayDenormalizableTrait;

    // -- Construction

    /**
     * @param list<Duration> $durations
     */
    public function __construct(
        /**
         * @var list<Duration>
         */
        public array $durations,
    ) {
        foreach ($this->durations as $index => $duration) {
            for ($previousIndex = 0; $previousIndex < $index; ++$previousIndex) {
                if ($this->durations[$previousIndex]->isEqualTo($duration)) {
                    throw new \InvalidArgumentException('Durations must be unique.');
                }
            }
        }
    }

    // -- Array normalizable

    /**
     * @param NormalizedDurations $data
     */
    #[\Override]
    public static function denormalize(array $data): self
    {
        $durations = [];
        foreach ($data as $value) {
            $durations[] = Duration::denormalize($value);
        }

        return new self($durations);
    }

    /**
     * @return NormalizedDurations
     */
    #[\Override]
    public function normalize(): array
    {
        $normalizedDurations = [];
        foreach ($this->durations as $duration) {
            $normalizedDurations[] = $duration->normalize();
        }

        return $normalizedDurations;
    }

    // -- Accessors

    public function contains(Duration $duration): bool
    {
        foreach ($this->durations as $existingDuration) {
            if ($existingDuration->isEqualTo($duration)) {
                return true;
            }
        }

        return false;
    }

    public function notContains(Duration $duration): bool
    {
        return !$this->contains($duration);
    }
}
