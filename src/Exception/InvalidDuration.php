<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Exception;

/**
 * @psalm-immutable
 */
final class InvalidDuration extends \InvalidArgumentException
{
    public function __construct(int $microseconds)
    {
        parent::__construct(sprintf(
            'A duration of %d microseconds is not valid. A duration must not be negative.',
            $microseconds,
        ));
    }
}
