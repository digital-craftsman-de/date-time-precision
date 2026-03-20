<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Exception;

/**
 * @psalm-immutable
 */
final class InvalidMonth extends \InvalidArgumentException
{
    public function __construct(int $month)
    {
        parent::__construct(sprintf(
            'A month %d is not a valid.',
            $month,
        ));
    }
}
