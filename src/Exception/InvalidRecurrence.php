<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Exception;

/**
 * @psalm-immutable
 */
final class InvalidRecurrence extends \InvalidArgumentException
{
    public function __construct(string $reason)
    {
        parent::__construct(sprintf(
            'The recurrence is not valid. %s',
            $reason,
        ));
    }
}
