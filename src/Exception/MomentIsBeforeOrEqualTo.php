<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Exception;

/**
 * @psalm-immutable
 *
 * @codeCoverageIgnore
 */
final class MomentIsBeforeOrEqualTo extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('The moment is before or equal to but must not be.');
    }
}
