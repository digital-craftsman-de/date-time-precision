<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Exception;

/** @psalm-immutable */
final class DurationIsZero extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('The duration is zero but must not be.');
    }
}
