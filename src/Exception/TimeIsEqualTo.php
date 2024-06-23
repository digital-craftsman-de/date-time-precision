<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Exception;

/**
 * @psalm-immutable
 *
 * @codeCoverageIgnore
 */
final class TimeIsEqualTo extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('The time is equal but must not be.');
    }
}
