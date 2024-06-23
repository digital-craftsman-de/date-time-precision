<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Exception;

/**
 * @psalm-immutable
 *
 * @codeCoverageIgnore
 */
final class DateIsAfter extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('The date is after but must not be.');
    }
}
