<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\ArrayNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableArrayDenormalizableTrait;

/**
 * @psalm-import-type NormalizedTimeRange from TimeRange
 *
 * @psalm-type NormalizedTimeRanges = list<NormalizedTimeRange>
 */
final readonly class TimeRanges implements ArrayNormalizable, NullableArrayDenormalizable
{
    use NullableArrayDenormalizableTrait;

    // -- Construction

    /**
     * @param list<TimeRange> $timeRanges
     */
    public function __construct(
        /**
         * @var list<TimeRange>
         */
        public array $timeRanges,
    ) {
        foreach ($this->timeRanges as $index => $timeRange) {
            for ($previousIndex = 0; $previousIndex < $index; ++$previousIndex) {
                if ($this->timeRanges[$previousIndex]->isEqualTo($timeRange)) {
                    throw new \InvalidArgumentException('TimeRanges must be unique.');
                }
            }
        }
    }

    // -- Array normalizable

    /**
     * @param NormalizedTimeRanges $data
     */
    #[\Override]
    public static function denormalize(array $data): self
    {
        $timeRanges = [];
        foreach ($data as $value) {
            $timeRanges[] = TimeRange::denormalize($value);
        }

        return new self($timeRanges);
    }

    /**
     * @return NormalizedTimeRanges
     */
    #[\Override]
    public function normalize(): array
    {
        $normalizedTimeRanges = [];
        foreach ($this->timeRanges as $timeRange) {
            $normalizedTimeRanges[] = $timeRange->normalize();
        }

        return $normalizedTimeRanges;
    }

    // -- Accessors

    public function contains(TimeRange $timeRange): bool
    {
        foreach ($this->timeRanges as $existingTimeRange) {
            if ($existingTimeRange->isEqualTo($timeRange)) {
                return true;
            }
        }

        return false;
    }

    public function notContains(TimeRange $timeRange): bool
    {
        return !$this->contains($timeRange);
    }
}
