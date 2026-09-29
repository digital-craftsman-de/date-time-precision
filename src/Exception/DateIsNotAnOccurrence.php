<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Exception;

/** @psalm-immutable */
final class DateIsNotAnOccurrence extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('The date is not an occurrence of the recurrence but must be.');
    }
}
