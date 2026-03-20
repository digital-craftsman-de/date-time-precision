<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Exception;

/** @psalm-immutable */
final class MomentIsAfterOrEqualTo extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('The moment is after or equal to but must not be.');
    }
}
