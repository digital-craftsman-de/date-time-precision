<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Clock;

use DigitalCraftsman\DateTimePrecision\Moment;

interface Clock
{
    public function now(): Moment;
}
