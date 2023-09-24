# Upgrade guide

## From 0.7.* to 0.8.0

### Upgrade to at least PHP 8.2

Support for PHP 8.1 was dropped, so you have to upgrade to at least PHP 8.2.

### Dropped support for Symfony below 6.3

Support for Symfony below 6.3 was dropped, so you have to upgrade to at least Symfony 6.3. This is the only way to prevent deprecations from being thrown for the cachable support.

## From 0.6.* to 0.7.0

No breaking changes

## From 0.5.* to 0.6.0

No breaking changes

## From 0.4.* to 0.5.0

You can remove `YearNormalizer` from your normalizers if you registered it manually.

## From 0.3.* to 0.4.0

No breaking changes

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

No breaking changes
