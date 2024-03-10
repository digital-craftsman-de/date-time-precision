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

Additionally, the package provides a streamlined way to have the system running in `UTC` but still do the modifications in the relevant timezone. The internal `DateTime` is always in `UTC` and only internally converted to the relevant timezone for modifications. This way you can be sure that you're not missing or receiving an hour due to a switch of summer-time to winter-time in the relevant timezone.

This Symfony bundle includes Symfony normalizers for automatic normalization and denormalization and Doctrine types to store the objects directly in the database. 

As it's a central part of an application, it's tested thoroughly (including mutation testing).

[![Latest Stable Version](http://poser.pugx.org/digital-craftsman/date-time-precision/v)](https://packagist.org/packages/digital-craftsman/date-time-precision)
[![PHP Version Require](http://poser.pugx.org/digital-craftsman/date-time-precision/require/php)](https://packagist.org/packages/digital-craftsman/date-time-precision)
[![codecov](https://codecov.io/gh/digital-craftsman-de/date-time-precision/branch/main/graph/badge.svg?token=vZ0IvKPj2f)](https://codecov.io/gh/digital-craftsman-de/date-time-precision)
[![Total Downloads](http://poser.pugx.org/digital-craftsman/date-time-precision/downloads)](https://packagist.org/packages/digital-craftsman/date-time-precision)
[![License](http://poser.pugx.org/digital-craftsman/date-time-precision/license)](https://packagist.org/packages/digital-craftsman/date-time-precision)

## Installation and configuration

Install package through composer:

```shell
composer require digital-craftsman/date-time-precision
```

> ⚠️ This bundle can be used (and is being used) in production, but hasn't reached version 1.0 yet. Therefore, there will be breaking changes between minor versions. I'd recommend that you require the bundle only with the current minor version like `composer require digital-craftsman/date-time-precision:0.9.*`. Breaking changes are described in the releases and [the changelog](./CHANGELOG.md). Updates are described in the [upgrade guide](./UPGRADE.md).

## When would I need that?

Basically whenever you use a `DateTime` object for something other than a single moment.

Storing more information in those cases just lead to more questions, like "When storing the month, do we store the first of month at midnight?" and therefore increases complexity. Additionally, you need mutate or reduce the point in time to be able to compare it. With the package it will be as easy as:

```php
if ($now
    ->timeInTimeZone($facilityTimeZone)
    ->isBefore($facility->openFrom)
) {
    throw new FacilityIsNotOpenYet();
}
```

The idea is that your system and all variables can still remain in the timezone `UTC` and you only call mutations on it when needed for a comparison.

```php
if ($now
    ->dateInTimeZone($facilityTimeZone)
    ->isBefore($facility->earliestDayOfBooking)
) {
    throw new BookingNotPossibleYet();
}
```

Modifications work the same way.

```php
$bookingsAllowedFrom = $now->modifyInTimeZone('+ 7 days', $facilityTimeZone);
```

The resulting `$bookingsAllowedFrom` is still a date time with timezone `UTC` but the modification is done in the relevant timezone.

## Integration

For the best code readability, it's best to use the `Moment` provided with the package as a full replacement for `\DateTime` or `\DateTimeImmutable` when you're speaking about a moment in time and the others value objects for the rest.
The package provides normalizers and Doctrine types for `Moment` and all parts.

The Doctrine types are automatically registered with the bundle with the following type names:

- `dtp_moment`
- `dtp_time`
- `dtp_date`
- `dtp_month`
- `dtp_year`

## Design

### Immutability

All mutations on the `Moment` and its parts are immutable.

## Contribution

The local setup is build with Docker and controlled through Make commands. Run `make` to see all available commands and what they do.

Before creating a PR or pushing any code, please run `make verify` to run all tests and validations locally.
