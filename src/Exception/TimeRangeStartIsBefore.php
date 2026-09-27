<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Exception;

/** @psalm-immutable */
final class TimeRangeStartIsBefore extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('The start of the time range is before but must not be.');
    }
}
