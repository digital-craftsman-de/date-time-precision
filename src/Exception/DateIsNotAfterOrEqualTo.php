<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Exception;

/** @psalm-immutable */
final class DateIsNotAfterOrEqualTo extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('The date is not after or equal to but must be.');
    }
}
