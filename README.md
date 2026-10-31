# Date Time Precision

**Use only as much date and time as you actually need.**

PHP has exactly one type for anything related to time: `DateTime` (or `DateTimeImmutable`). It always contains a date, a time down to microseconds and a timezone – even if you only mean "08:00", "Christmas" or "March 2026".

This package replaces it with small value objects that contain exactly the information you're talking about. Nothing more.

| You mean …                          | Use        | Contains                    |
|-------------------------------------|------------|-----------------------------|
| a specific point in time            | `Moment`   | date + time, always in UTC  |
| a date like a birthday or a holiday | `Date`     | year, month, day            |
| a time of day like opening hours    | `Time`     | hour, minute, second, µs    |
| a month like a billing month        | `Month`    | year, month                 |
| a year                              | `Year`     | year                        |
| a calendar week                     | `Week`     | ISO year, week number       |
| a day of the week                   | `Weekday`  | Monday … Sunday             |
| a day of the month                  | `Day`      | 1 … 31                      |

There are also value objects for durations, calendar periods, ranges and recurrences (see below).

[![Latest Stable Version](https://img.shields.io/badge/stable-1.0.0-blue)](https://packagist.org/packages/digital-craftsman/date-time-precision)
[![PHP Version Require](https://img.shields.io/badge/php-8.4|8.5-5b5d95)](https://packagist.org/packages/digital-craftsman/date-time-precision)
[![codecov](https://codecov.io/gh/digital-craftsman-de/date-time-precision/branch/main/graph/badge.svg?token=vZ0IvKPj2f)](https://codecov.io/gh/digital-craftsman-de/date-time-precision)
![Packagist Downloads](https://img.shields.io/packagist/dt/digital-craftsman/date-time-precision)
![Packagist License](https://img.shields.io/packagist/l/digital-craftsman/date-time-precision)

## Why?

Every piece of information you don't need is a source of bugs. When a `DateTime` is used for something that isn't a point in time, you suddenly have to answer questions that have nothing to do with your domain:

- Opening hours are stored as `DateTime`. On which date? In which timezone? Do I need to move it to today before comparing?
- A billing month is stored as `DateTime`. Is it the first of the month at midnight? Midnight in which timezone?
- A due date is stored as `DateTime`. Does `$dueDate < $now` already fail at 00:00 UTC or at 00:00 local time?

Every developer answers those questions slightly differently, and every variant needs its own normalization before it can be compared. That's where the bugs come from.

With precise value objects these questions simply don't exist. A `Time` has no date, a `Month` has no day and a `Date` has no timezone. The code describes what's meant and nothing else:

**Before**

```php
$nowInFacility = $now->setTimezone($facilityTimeZone);
$openFrom = $nowInFacility->setTime(
    (int) $facility->openFrom->format('H'),
    (int) $facility->openFrom->format('i'),
);

if ($nowInFacility < $openFrom) {
    throw new FacilityIsNotOpenYet();
}
```

**After**

```php
if ($now->isBeforeInTimeZone($facility->openFrom, $facilityTimeZone)) {
    throw new FacilityIsNotOpenYet();
}
```

`$now` is a `Moment` and `$facility->openFrom` is a `Time`. The moment is reduced to the time of day in the facility's timezone and only then compared. You don't have to think about it.

In short:

1. **Less data** – every value only contains what it represents.
2. **Less variance** – there is exactly one way to represent a date, a month or a time of day.
3. **Fewer bugs and more readable code** – no normalization before comparisons, no hidden timezone or date.
4. **No new date logic** – everything is calculated by PHP's own `DateTimeImmutable`.

## A thin wrapper, not a reimplementation

This package doesn't reinvent date and time handling. The value objects are only a thin layer over `DateTimeImmutable`. Every calculation – modifications, differences, timezone conversions and parsing of arbitrary formats – is delegated to it. Only trivial operations without any calendar logic are done directly for performance, like comparing two dates by their numbers or reading the normalized format `2026-03-01` (validated with PHP's `checkdate`).

That's intentional. Date and time calculations are full of edge cases: switches between summer and winter time, leap years, months of different length, timezones that changed their offset over the years. PHP's implementation handles them and has been hardened over many years in countless applications. Writing that logic again would only mean new bugs.

So with this package:

- edge cases behave exactly like they do in native PHP, there are no surprises.
- there is no custom calendar logic that could break.
- you can reason about the result with your existing knowledge of `DateTimeImmutable`.

This also applies where PHP isn't intuitive. For example 31.01. + 1 month is 03.03. like with `DateTimeImmutable::modify('+1 month')`. The package doesn't "fix" this, as that would mean a second, different behaviour.

The value objects add precision and readability – the calculations stay where they belong.

## Installation

```shell
composer require digital-craftsman/date-time-precision
```

The package follows [semantic versioning](https://semver.org). Changes are described in [the changelog](./CHANGELOG.md) and breaking changes in the [upgrade guide](./UPGRADE.md).

## The basic rule: Moments are UTC, everything else has no timezone

- A `Moment` is always stored in UTC. A `DateTime` in another timezone is converted to UTC when the `Moment` is created (the point in time stays the same).
- `Date`, `Time`, `Month`, `Year` etc. don't have a timezone at all. They're just the values.
- Whenever a `Moment` meets one of them, you tell it in which timezone to look at it. That's what the `*InTimeZone` methods are for.

```php
$now = Moment::fromString('2026-03-29 07:30:00');                       // UTC
$start = Moment::fromStringInTimeZone('2026-03-29 08:00', $berlin);    // converted to UTC

$date = $now->dateInTimeZone($berlin);   // Date
$time = $now->timeInTimeZone($berlin);   // Time
$month = $now->monthInTimeZone($berlin); // Month
```

### Comparing

The same comparison methods work with all types. The type of the parameter decides which part of the moment is compared:

```php
$now->isBeforeInTimeZone($facility->openFrom, $facilityTimeZone);          // Time
$now->isBeforeInTimeZone($facility->earliestBookingDate, $facilityTimeZone); // Date
$now->isAfterInTimeZone($contract->lastMonth, $customerTimeZone);           // Month
```

Values of the same type are compared directly:

```php
$dueDate->isBefore($today);
$billingMonth->isEqualTo($currentMonth);
$date->isBetween($start, $end);
```

Every comparison has an assertion counterpart which throws an exception. You can pass your own exception:

```php
$endsAt->mustBeAfter($startsAt);
$now->mustNotBeBeforeInTimeZone($earliestBookingDate, $timeZone, static fn () => new BookingNotPossibleYet());
```

### Modifying

All value objects are immutable. Modifications on a `Moment` that depend on the calendar are done in the given timezone, the result is still in UTC:

```php
$bookingsAllowedFrom = $now->modifyInTimeZone('+7 days', $facilityTimeZone);
```

This way you don't gain or lose an hour when there is a switch between summer and winter time in that timezone.

## Durations and calendar periods

"6 hours" and "1 day" sound similar but aren't. Therefore there are two different value objects:

- `Duration` is **elapsed time** like 90 minutes. It's always exact and independent of any timezone (microsecond precision).
- `CalendarPeriod` is a **movement in the calendar** like 1 day, 2 weeks, 3 months, 1 quarter or 1 year. Its length depends on the calendar, so it's applied in a timezone.

```php
$expiresAt = $now->add(Duration::fromHours(6));
$sameTimeTomorrow = $now->addInTimeZone(CalendarPeriod::days(1), $facilityTimeZone);
```

On the night of the time switch `$expiresAt` is exactly 6 hours later, while `$sameTimeTomorrow` is 23 or 25 hours later – but at the same local time.

Values without a time don't need a timezone. They only accept units that fit their precision (e.g. a `Month` can't be moved by days). A `Time` accepts a `Duration` and wraps around midnight.

```php
$dueDate = $invoiceDate->add(CalendarPeriod::days(14));
$nextBillingMonth = $billingMonth->add(CalendarPeriod::quarters(1));
$end = $start->add(Duration::fromMinutes(90));
```

The distance between two values is returned in the same way:

```php
$duration = $startedAt->durationUntil($endedAt);                       // Duration
$days = $startDate->periodUntil($endDate, CalendarUnit::DAY)->amount;  // int
```

As all calculations are done by `DateTimeImmutable` (see [A thin wrapper, not a reimplementation](#a-thin-wrapper-not-a-reimplementation)), they follow its behaviour, even where it's not intuitive. For example 31.01. + 1 month is 03.03. and from 31.01. until 01.03. is 0 full months.

## Ranges

| Range         | Type                                                       | Example                                         |
|---------------|------------------------------------------------------------|-------------------------------------------------|
| `DateRange`   | closed – start and end are included                        | 01.01. until 03.01. are 3 days                  |
| `MomentRange` | half-open – the end isn't included                         | 10:00–12:00 doesn't overlap with 12:00–14:00    |
| `TimeRange`   | half-open, may wrap around midnight, `00:00` as end = 24:00 | 21:00–03:00 is a night shift                   |

```php
$openingHours = new TimeRange(Time::fromString('08:00'), Time::fromString('20:00'));

if ($openingHours->notContainsRange($reservation->timeRangeInTimeZone($facilityTimeZone))) {
    throw new ReservationIsOutsideOfOpeningHours();
}
```

Whether start and end count for `contains` can be changed with a `PeriodLimit`:

```php
$openingHours->contains($reservationEnd, PeriodLimit::INCLUDING_START_AND_END);
```

Stricter rules can be enforced with guards, e.g. in the constructor of your own value object:

```php
$timeRange->mustNotStartBefore(Time::fromString('05:00'));
$timeRange->mustNotWrapAroundMidnight(static fn () => new TimeRangeMustBeWithinADay());
```

## Weeks and recurrences

`Week` is a calendar week according to ISO 8601. It starts on Monday and belongs to the year of its Thursday, so around new year the year of a week can differ from the year of its dates.

```php
$week = $date->week();          // e.g. 2026-W01 for 29.12.2025
$monday = $date->startOfWeek();
```

`Recurrence` describes on which dates something happens: daily, on specific weekdays or on specific days of the month (days which don't exist in a month are skipped). It contains neither a time nor a start or end.

```php
$recurrence = Recurrence::weekly(new Weekdays([Weekday::MONDAY, Weekday::WEDNESDAY]));

$nextReminderAt = $recurrence->nextOccurrenceAtTimeInTimeZone($reminderTime, $now, $userTimeZone);
$lessonDates = $recurrence->occurrencesBetween($seriesStart, $seriesEnd);
```

## Collections

Every value object has a collection with unique values (e.g. `Dates`, `Days`, `Weekdays`, `Months`, `TimeRanges`). The collections are countable, iterable and provide methods like `filter`, `map`, `sort`, `first`, `last`, `min` and `max`.

## Symfony and Doctrine

The bundle integrates everything automatically:

- **Serializer** – all value objects are normalized and denormalized through [`digital-craftsman/self-aware-normalizers`](https://github.com/digital-craftsman-de/self-aware-normalizers).
- **Doctrine** – there is a Doctrine type for every value object, registered automatically. The class name is the type name:

```php
#[ORM\Entity]
class Facility
{
    #[ORM\Column(type: Moment::class)]
    public Moment $createdAt;

    #[ORM\Column(type: Time::class)]
    public Time $openFrom;

    #[ORM\Column(type: Date::class)]
    public Date $earliestBookingDate;
}
```

- **Clock** – inject the `Clock` interface to get the current `Moment`. `SystemClock` is used by default and replaced with `FrozenClock` in the `test` environment, so you can freeze the time in tests:

```php
$now = $this->clock->now();

// In tests
$clock->freeze(Moment::fromString('2026-01-01 12:00:00'));
```

## Quality

As time handling is a central part of every application, the package is tested thoroughly, including mutation testing with 100% MSI. More than 80% of the code in this repository are tests.

## Contribution

The local setup is built with Docker and controlled through Make commands. Run `make` to see all available commands.

Before creating a PR, please run `make verify` to run all tests and validations locally.
