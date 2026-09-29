<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Exception;

/** @psalm-immutable */
final class TimeRangeStartIsEqualToEnd extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('The start of the time range is equal to the end but must not be. A full day is expressed as 00:00 until 00:00.');
    }
}
