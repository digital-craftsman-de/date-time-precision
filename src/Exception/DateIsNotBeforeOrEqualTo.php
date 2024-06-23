<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Exception;

/**
 * @psalm-immutable
 *
 * @codeCoverageIgnore
 */
final class DateIsNotBeforeOrEqualTo extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('The date is not before or equal to but must be.');
    }
}
