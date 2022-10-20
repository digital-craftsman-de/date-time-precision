# Upgrade guide

## From 0.4.* to 0.5.0

No breaking changes

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
