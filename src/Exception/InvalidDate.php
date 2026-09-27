<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Exception;

/**
 * @psalm-immutable
 */
final class InvalidDate extends \InvalidArgumentException
{
    public function __construct(
        int $year,
        int $month,
        int $day,
    ) {
        parent::__construct(sprintf(
            'The day %d does not exist in the month %d of the year %d.',
            $day,
            $month,
            $year,
        ));
    }
}
