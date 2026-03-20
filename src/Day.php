<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\IntNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableIntDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableIntDenormalizableTrait;

final readonly class Day implements IntNormalizable, NullableIntDenormalizable
{
    use NullableIntDenormalizableTrait;

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

    public static function fromDateTime(\DateTimeImmutable $dateTime): self
    {
        $day = (int) $dateTime->format('j');

        return new self($day);
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
