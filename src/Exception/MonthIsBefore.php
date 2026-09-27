<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Exception;

/** @psalm-immutable */
final class MonthIsBefore extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('The month is before but must not be.');
    }
}
