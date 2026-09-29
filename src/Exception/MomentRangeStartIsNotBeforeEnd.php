<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Exception;

/** @psalm-immutable */
final class MomentRangeStartIsNotBeforeEnd extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('The start of the moment range is not before the end but must be.');
    }
}
