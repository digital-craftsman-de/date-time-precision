<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Exception;

/**
 * @psalm-immutable
 *
 * @codeCoverageIgnore
 */
final class MomentIsNotEqual extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('The moment is not equal but must be.');
    }
}
