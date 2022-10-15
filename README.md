# Parts of a `DateTime`

A Symfony bundle to work with parts of what a `DateTime` consists of (`Date`, `Time`, `Month` and `Year`). 
It includes Symfony normalizers for automatic normalization and denormalization and Doctrine types to store the parts directly in the database when you explicitly don't want the granularity. 

As it's a central part of an application, it's tested thoroughly (including mutation testing).

[![Latest Stable Version](http://poser.pugx.org/digital-craftsman/datetime-parts/v)](https://packagist.org/packages/digital-craftsman/datetime-parts)
[![PHP Version Require](http://poser.pugx.org/digital-craftsman/datetime-parts/require/php)](https://packagist.org/packages/digital-craftsman/datetime-parts)
[![codecov](https://codecov.io/gh/digital-craftsman-de/datetime-parts/branch/main/graph/badge.svg?token=BL0JKZYLBG)](https://codecov.io/gh/digital-craftsman-de/datetime-parts)
[![Total Downloads](http://poser.pugx.org/digital-craftsman/datetime-parts/downloads)](https://packagist.org/packages/digital-craftsman/datetime-parts)
[![License](http://poser.pugx.org/digital-craftsman/datetime-parts/license)](https://packagist.org/packages/digital-craftsman/datetime-parts)

## Installation and configuration

Install package through composer:

```shell
composer require digital-craftsman/datetime-parts
```

> ⚠️ This bundle can be used (and is being used) in production, but hasn't reached version 1.0 yet. Therefore, there will be breaking changes between minor versions. I'd recommend that you require the bundle only with the current minor version like `composer require digital-craftsman/datetime-parts:0.1.*`. Breaking changes are described in the releases and [the changelog](./CHANGELOG.md). Updates are described in the [upgrade guide](./UPGRADE.md).

## When would I need that?

Basically whenever you don't talk about a point in time.

- If you're calculating a settlement for a specific month.
- When you're storing a time of day that is relevant on every day like business hours.

Storing more information in those cases just lead to more questions, like "When storing the month, do we store the first of month at midnight?" and therefore increases complexity. Additionally, you need mutate or reduce the point in time to be able to compare it. With the package it will be as easy as:

```php
if ($now
    ->timeInTimeZone($facilityTimeZone)
    ->isBefore($facility->openFrom)
) {
    throw new FacilityIsNotOpenYet();
}
```

## Integration

For the best code readability, it's best to use the `DateTime` provided with the package as a full replacement for `\DateTime` or `\DateTimeImmutable`.
The package provides normalizers and doctrine types for `DateTime` and all parts.

## Design

### Immutability

All mutations on the `DateTime` and its parts are immutable.

### Time zone

The package is primarily build for the use case, that your system is running in the time zone `UTC` and you're converting the points in time into the relevant time zone before doing comparisons. It includes helpers like `modifyInTimeZone(string $modifier, \DateTimeZone $timeZone)` to make the code more readable. 

## Contribution

The local setup is build with Docker and controlled through Make commands. Run `make` to see all available commands and what they do.

Before creating a PR or pushing any code, please run `make verify` to run all tests and validations locally.
