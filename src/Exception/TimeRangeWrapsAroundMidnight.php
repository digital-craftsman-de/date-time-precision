<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Exception;

/** @psalm-immutable */
final class TimeRangeWrapsAroundMidnight extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('The time range wraps around midnight but must not.');
    }
}
