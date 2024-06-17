<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Exception;

/**
 * @psalm-immutable
 *
 * @codeCoverageIgnore
 */
final class MomentIsNotBefore extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('The moment is not before but must be.');
    }
}
