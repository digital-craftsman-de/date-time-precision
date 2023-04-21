# Changelog

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
