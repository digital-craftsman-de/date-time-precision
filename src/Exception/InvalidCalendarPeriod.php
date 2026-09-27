<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Exception;

/**
 * @psalm-immutable
 */
final class InvalidCalendarPeriod extends \InvalidArgumentException
{
    public function __construct(int $amount)
    {
        parent::__construct(sprintf(
            'A calendar period with an amount of %d is not valid. The amount must not be negative.',
            $amount,
        ));
    }
}
