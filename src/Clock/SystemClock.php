<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Clock;

use DigitalCraftsman\DateTimePrecision\Moment;

final readonly class SystemClock implements Clock
{
    #[\Override]
    public function now(): Moment
    {
        return Moment::fromDateTime(new \DateTimeImmutable(
            'now',
            new \DateTimeZone('UTC'),
        ));
    }
}
