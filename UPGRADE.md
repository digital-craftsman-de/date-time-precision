# Upgrade guide

## From 0.15.* to 0.16.0

### Collections instead of arrays

`Date::datesUntil`, `Month::monthsUntil` and `Year::yearsUntil` return the collections `Dates`, `Months` and `Years` instead of arrays. The collections are countable and iterable, so `foreach` and `count` still work. Array functions need to be replaced with the methods of the collections or the list of values.

Before:
```php
$weekdays = array_filter(
    $start->datesUntil($end),
    static fn (Date $date): bool => $date->weekday() === Weekday::MONDAY,
);
```

After:
```php
$weekdays = $start
    ->datesUntil($end)
    ->filter(static fn (Date $date): bool => $date->weekday() === Weekday::MONDAY);

// Or when an array is needed
$dates = $start->datesUntil($end)->dates;
```

## From 0.14.* to 0.15.0

### Moment is always in UTC

Previously `Moment` kept the timezone of the given `\DateTimeImmutable`. This was the case for `Moment::fromDateTime`, `new Moment`, `denormalize` with an offset (like `+02:00`) and `toTimeZone`. Now the date time is converted to UTC on construction. The moment in time is kept, but all methods without an explicit timezone now work in UTC for those moments:

- `date`, `time`, `weekday`, `day`, `month`, `year`, `isAtMidnight` and `isNotAtMidnight` return the values in UTC.
- `format`, `normalize` and `__toString` return the values in UTC (with offset `+00:00`).
- `midnight`, `setTime` and `modify` are applied in UTC.

Comparisons and all `*InTimeZone` methods aren't affected.

If you create moments from a date time in another timezone (e.g. `$context->triggeredAt` of the Symfony scheduler) and rely on one of the methods above, switch to the matching `*InTimeZone` method:

Before:
```php
$now = Moment::fromDateTime($context->triggeredAt); // In Europe/Berlin
$today = $now->date();
```

After:
```php
$now = Moment::fromDateTime($context->triggeredAt); // Converted to UTC
$today = $now->dateInTimeZone(new \DateTimeZone('Europe/Berlin'));
```

As a side effect, a moment in another timezone can't be persisted with a shifted time anymore. With `TIMESTAMP WITHOUT TIME ZONE`, the offset of the normalized value was ignored by the database.

`toTimeZone` is deprecated as it has no effect anymore and will be removed in 1.0. Use the `*InTimeZone` methods instead.

### Validation of date

`Date` now validates that the day exists in the month and throws `InvalidDate` otherwise. Previously `new Date(new Month(new Year(2022), 2), new Day(31))` was accepted. Construction through `Date::fromString` or `Date::fromDateTime` isn't affected as `\DateTimeImmutable` already moves those days into the following month.

### Deprecated modifications in time zone for calendar values

`modifyInTimeZone` of `Date`, `Month` and `Year` is deprecated and will be removed in 1.0. Those values don't have a time and therefore the timezone has no effect. Use `add` and `subtract` with a `CalendarPeriod` or `modify` instead.

Before:
```php
$tomorrow = $date->modifyInTimeZone('+ 1 day', $timeZone);
$nextMonth = $month->modifyInTimeZone('+ 1 month', $timeZone);
```

After:
```php
$tomorrow = $date->add(CalendarPeriod::days(1));
$nextMonth = $month->next();
```

### Deprecated distance in minutes of time

`distanceInMinutesTo` of `Time` is deprecated and will be removed in 1.0. Use `durationUntil` instead. Be aware that `durationUntil` wraps around midnight when the given time is before the time, whereas `distanceInMinutesTo` returned the absolute distance.

Before:
```php
$minutes = $timeFrom->distanceInMinutesTo($timeTo);
```

After:
```php
$minutes = $timeFrom->durationUntil($timeTo)->inMinutes();
```

## From 0.13.* to 0.14.0

### Day as part of month

A construction of `new Month` used `int $day` as parameter and now has `Day $day`. Replace all instances where you used the default constructor.

## From 0.12.* to 0.13.0

### Switch to automatic doctrine types

Use the full class string in the doctrine column `type` instead of the custom names.

Before:
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
    #[ORM\Column(name: 'created_at', type: 'dtp_moment')]
    public Moment $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'dtp_moment')]
    public Moment $updatedAt;

    ...
```

After:
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

## From 0.11.* to 0.12.0

### Dropped support for PHP 8.3

Update to at least PHP 8.4.

### Dropped support for Symfony 7.3 and below

Update to at least the LTS version 7.4.

## From 0.10.* to 0.11.0

### Removed deprecated `isDate*` methods from `Moment`

The `isDate*` methods have all been removed and should be replaced with `is*InTimeZone` methods.

### Dropped custom normalizers

The custom normalizers have been dropped in favor of `digital-craftsman/self-aware-normalizers`. If you constructed or injected them somewhere manually, you need to replace them with the `StringNormalizableNormalizer` or `IntNormalizableNormalizer`. Otherwise, there is nothing to do, as they are registered automatically like the previous ones did.

### Dropped support for PHP 8.2

Support for PHP 8.2 was dropped, so you have to upgrade to at least PHP 8.3.

## From 0.9.* to 0.10.0

No breaking changes (just deprecations).

## From 0.8.* to 0.9.0

### Dropped support for Symfony 6.3

Support for Symfony 6.3 was dropped, so you have to upgrade to at least Symfony 6.4. You can also immediately upgrade to Symfony 7.

## From 0.7.* to 0.8.0

### Upgrade to at least PHP 8.2

Support for PHP 8.1 was dropped, so you have to upgrade to at least PHP 8.2.

### Dropped support for Symfony below 6.3

Support for Symfony below 6.3 was dropped, so you have to upgrade to at least Symfony 6.3. This is the only way to prevent deprecations from being thrown for the cachable support.

### UTC as supported timezone

Instances of `DateTime` can now only be created in the UTC timezone. This is independent on the configured default timezone in PHP. If you're relying on the another configured timezone, you ether need to specifically set the timezone yourself or use UTC. This is the expected use case.

### Renamed package

Renamed package from `digital-craftsman/datetime-parts` to `digital-craftsman/date-time-precision`. Update your `composer.json` accordingly.

### Renamed `DateTime`

Renamed `DateTime` to `Moment` including normalizer and Doctrine type. Replace all usages of `DateTime` with `Moment`.

### Updated Doctrine moment type to support milliseconds

When using `MomentType`, you need to migrate the database column to support milliseconds. 

## From 0.6.* to 0.7.0

No breaking changes.

## From 0.5.* to 0.6.0

No breaking changes.

## From 0.4.* to 0.5.0

You can remove `YearNormalizer` from your normalizers if you registered it manually.

## From 0.3.* to 0.4.0

No breaking changes.

## From 0.2.* to 0.3.0

### Rename variables

- `$monthOfYear` was renamed to `$month` in `Month`.
- `$dayOfMonth` was renamed to `$day` in `Date`.

You need to rename those variables if you accessed them directly.

Before:

```php
if ($month->monthOfYear === 1) {
    ...
}
if ($date->dayOfMonth === 15) {
    ...
}
```

After:

```php
if ($month->month === 1) {
    ...
}
if ($date->day === 15) {
    ...
}
```

## From 0.1.* to 0.2.0

No breaking changes.
