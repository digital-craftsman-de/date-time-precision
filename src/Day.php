<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\IntNormalizable;

final readonly class Day implements IntNormalizable
{
    // -- Construction

    public function __construct(
        public int $day,
    ) {
        if ($day < 1
            || $day > 31
        ) {
            throw new Exception\InvalidDay($day);
        }
    }

    // -- Int normalizable

    #[\Override]
    public static function denormalize(int $data): self
    {
        return new self($data);
    }

    #[\Override]
    public function normalize(): int
    {
        return $this->day;
    }
}
