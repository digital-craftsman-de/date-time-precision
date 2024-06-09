# Using `DateTime` with precision

When talking about dates, our language is quite imprecise. And that's usually not a problem as it's always used within a given context that is obvious to the parties involved in the discussion. As developers, we're often not domain experts and therefore, the context will most likely not be obvious to us. To improve the readability and reduce the potential for bugs, we must be as explicit as possible in our code.

The problem with PHP is, that the standard library only has `DateTime` (and it's immutable counterpart) for use to work with. It represents a specific moment in time in a specific timezone (whether that timezone/offset is explicitly defined or not). You can parse pretty much every date / time string into a `DateTime`, but it will always result in a moment. So comparing two `DateTime` objects to see if it's the same date, will fail when one of them is even a millisecond off or when one of them is in a different timezone then the other. Which is even more of an issue when you want to store all moments in UTC to be independent of the timezone of the user.

To solve this issue, this package introduces specific classes to work with more precision. 
- `Moment` (specific moment in time like `2024-05-03 17:59:10.632842` in time zone `UTC`) 
- `Time` (`00:00:00` to `23:59:59` like `15:30:00`)
- `Date` (like `2024-05-03`)
- `Weekday` (`MONDAY` to `SUNDAY` like `FRIDAY`)
- `Week` (year and week like `2024-18`)
- `CalendarWeek` (`1` to `53`, independent of year like `18`)
- `Month` (year and month like `2024-03`)
- `CalendarMonth` (`JANUARY` to `DECEMBER` like `MAY`)
- `Year` (like `2024`) 

TODO: OVERALL: Split into parts that are valuable right now and which can come later. Dependent on a current project.

TODO: Add `Weekday` as `MONDAY` to `SUNDAY`, `CalendarWeek` as 1 to 53 and `CalendarMonth` as `JANUARY` to `DECEMBER`.  
TODO: Remove milliseconds from `Time`.
TODO: Manipulation / Calculation of one component into another one is simpler
TODO: Add Clock component that returns `Moment` with `->now()`
TODO: Examples for use cases 
  - date of current moment, running in UTC
  - Is same month
  - Is after from moment to date
  - Move event from one day of the week to another (independent of whether it's forward or backwards)
TODO: Classes for `Hour`, `Minute`, `Second`, `Millisecond`?
TODO: TimeFrames? For all elements.

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

> ⚠️ This bundle can be used (and is being used) in production, but hasn't reached version 1.0 yet. Therefore, there will be breaking changes between minor versions. I'd recommend that you require the bundle only with the current minor version like `composer require digital-craftsman/date-time-precision:0.10.*`. Breaking changes are described in the releases and [the changelog](./CHANGELOG.md). Updates are described in the [upgrade guide](./UPGRADE.md).

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

## Integration

For the best code readability, it's best to use the `Moment` provided with the package as a full replacement for `\DateTime` or `\DateTimeImmutable` when you're speaking about a moment in time and the others value objects for the rest.
The package provides normalizers and Doctrine types for `Moment` and all parts.

The Doctrine types are automatically registered with the bundle with the following type names:

- `dtp_moment`
- `dtp_time`
- `dtp_date`
- `dtp_month`
- `dtp_year`

The package also contains a clock component consisting of the interface `Clock` with the two implementations `SystemClock` (for general use) and `FrozenClock` (for testing). The `SystemClock` will be autowired for the `Clock` and automatically replaced with `FrozenClock` in the test environment.

## Design

### Immutability

All mutations on the `Moment` and its parts are immutable.

## Contribution

The local setup is build with Docker and controlled through Make commands. Run `make` to see all available commands and what they do.

Before creating a PR or pushing any code, please run `make verify` to run all tests and validations locally.
