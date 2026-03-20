<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Exception;

/**
 * @psalm-immutable
 */
final class InvalidDay extends \InvalidArgumentException
{
    public function __construct(int $day)
    {
        parent::__construct(sprintf(
            'A day %d is not a valid day of the month.',
            $day,
        ));
    }
}
