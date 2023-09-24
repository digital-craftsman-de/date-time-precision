# Changelog

## 0.8.0

- **[Breaking change](./UPGRADE.md#upgrade-to-at-least-php-82)**: Dropped support for PHP 8.1.
- **[Breaking change](./UPGRADE.md#dropped-support-for-symfony-below-63)**: Dropped support for Symfony below 6.3.
- **[Breaking change](UPGRADE.md#utc-as-supported-timezone)**: Instances of `DateTime` are now always created in the UTC timezone (independent on the configured default timezone in PHP).
- Added support for PHP 8.3.
- Added support for the new normalizer caching mechanism of Symfony 6.3.
- Switched classes to be `readonly` (instead of just the properties).
- Removed custom code in `Date` and `Month` and used PHP SPL to handle date comparisons.
- Added `DateTime->isNotAfter`
- Added `DateTime->isNotAfterOrEqualTo`.
- Added `DateTime->isNotBeforeOrEqualTo`.
- Added `DateTime->isNotBefore`.
- Added `DateTime->isDateNotAfterInTimeZone`.
- Added `DateTime->isDateNotAfterOrEqualToInTimeZone`.
- Added `DateTime->isDateNotBeforeInTimeZone`.
- Added `DateTime->isDateNotBeforeOrEqualToInTimeZone`.
- Added `Date->isNotAfter`.
- Added `Date->isNotBefore`.
- Added `Date->isNotBeforeOrEqualTo`.
- Added `Date->isNotAfterOrEqualTo`.
- Added `Month->isNotBefore`.
- Added `Month->isNotBeforeOrEqualTo`.
- Added `Month->isNotAfter`.
- Added `Month->isNotAfterOrEqualTo`.
- Added `Year->isNotBefore`.
- Added `Year->isNotAfterOrEqualTo`.
- Added `Year->isNotAfter`.
- Added `Year->isNotBeforeOrEqualTo`.

## 0.7.0

- Added `Date->datesUntil(Date $date, PeriodLimit $periodLimit = PeriodLimit::INCLUDING_START_AND_END): array`.
- Added `Year->yearsUntil(Year $year, PeriodLimit $periodLimit = PeriodLimit::INCLUDING_START_AND_END): array`.
- Added `Year->modify(string $modifier): Year`.

## 0.6.1

- Added missing `DateTimeType->requiresSQLCommentHint(): bool`.
- Added missing `DateType->requiresSQLCommentHint(): bool`.
- Added missing `TimeType->requiresSQLCommentHint(): bool`.

## 0.6.0

- Added `Year->compareTo(self $year): int`.
- Added `Month->compareTo(self $month): int`.
- Added `Date->compareTo(self $date): int`.
- Updated `Time->compareTo(self $time): int` to use less custom code.

## 0.5.0

- Added `DateTime->isDateNotEqualToInTimeZone(DateTime $dateTime, \DateTimeZone $timeZone): bool`.
- Added `Date->toDateTimeInTimeZone(\DateTimeZone $timeZone): self`.
- Added `Date->modifyInTimeZone(string $modify, \DateTimeZone $timeZone): self`.
- Added `Month->toDateTimeInTimeZone(\DateTimeZone $timeZone): self`.
- Added `Month->modifyInTimeZone(string $modify, \DateTimeZone $timeZone): self`.
- Added `Year->toDateTimeInTimeZone(\DateTimeZone $timeZone): self`.
- Added `Year->modifyInTimeZone(string $modify, \DateTimeZone $timeZone): self`.
- Added `YearNormalizer` to automatic registered normalizers.

## 0.4.0

- Added `DateTime->isDateAfterInTimeZone(DateTime $dateTime, \DateTimeZone $timeZone): bool`.
- Added `DateTime->isDateAfterOrEqualToInTimeZone(DateTime $dateTime, \DateTimeZone $timeZone): bool`.
- Added `DateTime->isDateEqualToInTimeZone(DateTime $dateTime, \DateTimeZone $timeZone): bool`.
- Added `DateTime->isDateBeforeInTimeZone(DateTime $dateTime, \DateTimeZone $timeZone): bool`.
- Added `DateTime->isDateBeforeOrEqualToInTimeZone(DateTime $dateTime, \DateTimeZone $timeZone): bool`.

## 0.3.0

- Renamed `Month->$monthOfYear` to `Month->$month`.
- Renamed `Date->$dayOfMonth` to `Date->$day`.
- Added `DateTime->isAtMidnight(): bool`.
- Added `DateTime->isNotAtMidnight(): bool`.
- Added `DateTime->isAtMidnightInTimeZone(\DateTimeZone $timeZone): bool`.
- Added `DateTime->isNotAtMidnightInTimeZone(\DateTimeZone $timeZone): bool`.
- Added `DateTime->setTimeInTimeZone(Time $time, \DateTimeZone $timeZone): self`.

## 0.2.0

- Added `DateTime->formatInTimeZone(string $format, \DateTimeZone $timeZone)`.

## 0.1.0

- Initial release
