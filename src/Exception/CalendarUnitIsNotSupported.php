<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Exception;

use DigitalCraftsman\DateTimePrecision\CalendarUnit;

/**
 * @psalm-immutable
 */
final class CalendarUnitIsNotSupported extends \InvalidArgumentException
{
    /**
     * @param class-string $valueObjectClass
     */
    public function __construct(
        CalendarUnit $calendarUnit,
        string $valueObjectClass,
    ) {
        parent::__construct(sprintf(
            'The calendar unit %s is not supported by %s.',
            $calendarUnit->value,
            $valueObjectClass,
        ));
    }
}
