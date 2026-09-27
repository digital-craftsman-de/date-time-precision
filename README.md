# Using `DateTime` with precision

The only class in the PHP SPL to work with dates and times is `DateTime` (and it's immutable counterpart). It represents a specific moment in time in a specific timezone (whether that timezone/offset is explicitly defined or not). Unfortunately dates are complex and there is more than just a moment in time. For example there are

- time of day which is relevant on every day (like business hours).
- a specific date (like Christmas) which isn't bound to a timezone.
- a subset of a date time like time, date, month or year.

Basically, every time you're not talking about a specific moment, the `DateTime` classes contain not just more informationen then needed, but even misleading information.

This bundle / package tries to solve this issue by introducing a wrapper value object `Moment` for a moment in time and value objects for the more precise sub sets like `Time`, `Date`, `Month` and `Year`. 
It's only a thin wrapper over `DateTime` and uses it internally for all modifications and comparisons. This way you don't have to make sure that your `DateTime` is

- at a specific date to compare times.
- at midnight to compare dates.
- at the first of the month to compare months.
- at the first of the year to compare years.

Additionally, the package provides a streamlined way to have the system running in `UTC` but still do the modifications in the relevant timezone. The internal `DateTime` is always in `UTC` and only internally converted to the relevant timezone for modifications. A `DateTime` in another timezone or with an offset is converted to `UTC` when a `Moment` is created from it (the moment in time is kept). This way you can be sure that you're not missing or receiving an hour due to a switch of summer-time to winter-time in the relevant timezone.

There are also classes like `Day` or `Weekday` and collections like `Days` or `Weekdays`.

This Symfony bundle includes Symfony normalizers for automatic normalization and denormalization and Doctrine types to store the objects directly in the database. 

As it's a central part of an application, it's tested thoroughly (including mutation testing). Currently, more than 80% of the lines of code in this repository are tests.

[![Latest Stable Version](https://img.shields.io/badge/stable-0.14.0-blue)](https://packagist.org/packages/digital-craftsman/date-time-precision)
[![PHP Version Require](https://img.shields.io/badge/php-8.4|8.5-5b5d95)](https://packagist.org/packages/digital-craftsman/date-time-precision)
[![codecov](https://codecov.io/gh/digital-craftsman-de/date-time-precision/branch/main/graph/badge.svg?token=vZ0IvKPj2f)](https://codecov.io/gh/digital-craftsman-de/date-time-precision)
![Packagist Downloads](https://img.shields.io/packagist/dt/digital-craftsman/date-time-precision)
![Packagist License](https://img.shields.io/packagist/l/digital-craftsman/date-time-precision)

## Installation and configuration

Install package through composer:

```shell
composer require digital-craftsman/date-time-precision
```

> ⚠️ This bundle can be used (and is being used) in production, but hasn't reached version 1.0 yet. Therefore, there will be breaking changes between minor versions. I'd recommend that you require the bundle only with the current minor version like `composer require digital-craftsman/date-time-precision:0.14.*`. Breaking changes are described in the releases and [the changelog](./CHANGELOG.md). Updates are described in the [upgrade guide](./UPGRADE.md).

## When would I need that?

Basically whenever you use a `DateTime` object for something other than a single moment.

Storing more information in those cases just lead to more questions, like "When storing the month, do we store the first day of month at midnight, and if so, in which time zone?" and therefore increases complexity. Additionally, you need mutate or reduce the point in time to be able to compare it. With the package it will be as easy as:

```php
if ($now->isBeforeInTimeZone($facility->openFrom, $facilityTimeZone)) {
    throw new FacilityIsNotOpenYet();
}
```
`$now` is a `Moment` (in UTC) and `$facility->openFrom` is a `Time` (in the timezone of the facility).

The idea is that your system can run in `UTC` and all moments are in the timezone `UTC`. But all values that have an implicit time zone like a date or a time of day will be stored with just the data needed. This way we're getting rid of additional data that creates more surface for possible bugs. Through precise value objects and specific comparison functions, the code is more readable than before.

```php
if ($now->isBeforeInTimeZone($facility->earliestDayOfBooking)) {
    throw new BookingNotPossibleYet();
}
```
`$now` is a `Moment` (in UTC) and `$facility->earliestDayOfBooking` is a `Date` (in the timezone of the facility). The same method `isBeforeInTimeZone` that is used previously for the time comparison is the same that is used here. Depending on the type of the second parameter, the comparison is done on the relevant part of the moment.

Modifications work the same way.

```php
$bookingsAllowedFrom = $now->modifyInTimeZone('+ 7 days', $facilityTimeZone);
```

The resulting `$bookingsAllowedFrom` is still a date time with timezone `UTC` but the modification is done in the relevant timezone.

## Elapsed time and calendar movements

There are two different kinds of time spans and the package represents them with two different value objects:

- `Duration` is elapsed time, like 90 minutes or 6 hours. It's independent of any timezone and always exact, even across a switch from summer-time to winter-time. It's stored with microsecond precision.
- `CalendarPeriod` is a movement in the calendar, like 1 day, 2 weeks, 3 months, 1 quarter or 1 year. Days and months don't have a fixed length, therefore it's applied in the calendar of a timezone.

```php
$expiresAt = $now->add(Duration::fromHours(6));
$sameTimeTomorrow = $now->addInTimeZone(CalendarPeriod::days(1), $facilityTimeZone);
```

Across the switch from summer-time to winter-time, `$expiresAt` is exactly 6 hours later while `$sameTimeTomorrow` is 25 hours later but at the same local time.

Calendar values like `Date`, `Month` and `Year` don't have a time and therefore don't need a timezone. They only accept units which are at least as coarse as their own precision (e.g. a `Month` can't be moved by days). `Time` accepts a `Duration` and wraps around midnight.

```php
$dueDate = $invoiceDate->add(CalendarPeriod::days(14));
$nextBillingMonth = $billingMonth->add(CalendarPeriod::quarters(1));
$end = $start->add(Duration::fromMinutes(90));
```

All calculations are done with `\DateTimeImmutable` internally and therefore follow its behaviour even when it's not intuitive. For example 31.01. + 1 month results in 03.03. and 31.01. until 01.03. is 0 full months.

The distance between two values is returned as the type used for the modification:

```php
$duration = $startedAt->durationUntil($endedAt);
$days = $startDate->periodUntil($endDate, CalendarUnit::DAY)->amount;
```

## Ranges

There are ranges for dates, moments and times:

- `DateRange` is a closed range. Start and end are both part of the range (e.g. 01.01. until 03.01. are 3 days).
- `MomentRange` is a half-open range. The end isn't part of the range, therefore a range ending at 12:00 doesn't overlap with a range starting at 12:00.
- `TimeRange` is a half-open range of times of a day. An end of 00:00 is the end of the day (24:00), 00:00 until 00:00 is the full day and a range may wrap around midnight (e.g. 21:00 until 03:00).

```php
$openingHours = new TimeRange(Time::fromString('08:00'), Time::fromString('20:00'));
if ($openingHours->notContainsRange($reservation->timeRangeInTimeZone($facilityTimeZone))) {
    throw new ReservationIsOutsideOfOpeningHours();
}
```

Whether start and end are included in `contains` can be defined with a `PeriodLimit`. The default follows the range (both for `DateRange`, only the start for `MomentRange` and `TimeRange`).

```php
$isWithinOpeningHours = $openingHours->contains($reservationEnd, PeriodLimit::INCLUDING_START_AND_END);
```

More strict rules for a `TimeRange` can be enforced with guards, e.g. in the constructor of your own value object:

```php
$timeRange->mustNotStartBefore(Time::fromString('05:00'));
$timeRange->mustNotWrapAroundMidnight(static fn () => new TimeRangeMustBeWithinADay());
```

## Integration

For the best code readability, it's best to use the `Moment` provided with the package as a full replacement for `\DateTime` or `\DateTimeImmutable` when you're speaking about a moment in time and the others value objects for the rest.
The package integrates with the normalizers of `digital-craftsman/self-aware-normalizers` and provides Doctrine types (that use those interfaces) for `Moment` and all parts.

The value objects implement the relevant interfaces for the doctrine types and therefore can be used directly in your doctrine entities like the following:

```php
<?php

declare(strict_types=1);

namespace App\Entity;

use DigitalCraftsman\DateTimePrecision\Moment;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
#[ORM\Table(name: 'facility')]
class Facility
{
    ...
    
    /** @psalm-readonly */
    #[ORM\Column(name: 'created_at', type: Moment::class)]
    public Moment $createdAt;

    #[ORM\Column(name: 'updated_at', type: Moment::class)]
    public Moment $updatedAt;

    ...
```

The package also contains a clock component consisting of the interface `Clock` with the two implementations `SystemClock` (for general use) and `FrozenClock` (for testing). The `SystemClock` will be autowired for the `Clock` and automatically replaced with `FrozenClock` in the test environment.

## Design

### Immutability

All mutations on the `Moment` and its parts are immutable.

## Contribution

The local setup is build with Docker and controlled through Make commands. Run `make` to see all available commands and what they do.

Before creating a PR or pushing any code, please run `make verify` to run all tests and validations locally.
