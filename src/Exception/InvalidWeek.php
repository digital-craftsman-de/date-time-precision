<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Exception;

/**
 * @psalm-immutable
 */
final class InvalidWeek extends \InvalidArgumentException
{
    public function __construct(
        int $year,
        int $week,
    ) {
        parent::__construct(sprintf(
            'The week %d does not exist in the ISO year %d.',
            $week,
            $year,
        ));
    }
}
