# Changelog

## 0.5.0

- Added `isDateNotEqualToInTimeZone(DateTime $dateTime, \DateTimeZone $timeZone): bool` in `DateTime`.

## 0.4.0

- Added `isDateAfterInTimeZone(DateTime $dateTime, \DateTimeZone $timeZone): bool` in `DateTime`.
- Added `isDateAfterOrEqualToInTimeZone(DateTime $dateTime, \DateTimeZone $timeZone): bool` in `DateTime`.
- Added `isDateEqualToInTimeZone(DateTime $dateTime, \DateTimeZone $timeZone): bool` in `DateTime`.
- Added `isDateBeforeInTimeZone(DateTime $dateTime, \DateTimeZone $timeZone): bool` in `DateTime`.
- Added `isDateBeforeOrEqualToInTimeZone(DateTime $dateTime, \DateTimeZone $timeZone): bool` in `DateTime`.

## 0.3.0

- Renamed `$monthOfYear` to `$month` in `Month`.
- Renamed `$dayOfMonth` to `$day` in `Date`.
- Added `isAtMidnight(): bool` in `DateTime`.
- Added `isNotAtMidnight(): bool` in `DateTime`.
- Added `isAtMidnightInTimeZone(\DateTimeZone $timeZone): bool` in `DateTime`.
- Added `isNotAtMidnightInTimeZone(\DateTimeZone $timeZone): bool` in `DateTime`.
- Added `setTimeInTimeZone(Time $time, \DateTimeZone $timeZone): self` in `DateTime`.

## 0.2.0

- Added `formatInTimeZone(string $format, \DateTimeZone $timeZone)` in `DateTime`.

## 0.1.0

- Initial release
