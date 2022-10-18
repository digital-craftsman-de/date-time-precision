# Changelog

## 0.3.0

- Renamed `$monthOfYear` to `$month` in `Month`.
- Renamed `$dayOfMonth` to `$day` in `Date`.
- Added `isAtMidnight(): bool` in `DateTime`.
- Added `isNotAtMidnight(): bool` in `DateTime`.
- Added `isAtMidnightInTimeZone(\DateTimeZone $timeZone): bool` in `DateTime`.
- Added `isNotAtMidnightInTimeZone(\DateTimeZone $timeZone): bool` in `DateTime`.
- Added `setTimeInTimeZone(Time $time, \DateTimeZone $timeZone): self` in `DateTime`.

## 0.2.0

- Added DateTime->formatInTimeZone.

## 0.1.0

- Initial release
