<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Exception;

/** @psalm-immutable */
final class TimeIsNotEqualTo extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('The time is not equal but must be.');
    }
}
