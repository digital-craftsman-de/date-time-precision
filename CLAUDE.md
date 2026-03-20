# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

A Symfony bundle (`digital-craftsman/date-time-precision`) providing precise date/time value objects as thin wrappers over PHP's `DateTimeImmutable`. The core idea: instead of using `DateTime` for everything, use specific value objects (`Moment`, `Date`, `Time`, `Month`, `Year`, `Day`, `Weekday`, `Weekdays`) that carry only the data they represent.

All value objects are `final readonly` and immutable. The system assumes UTC internally; timezone-aware operations convert temporarily to the target timezone for the operation, then back to UTC.

## Commands

All commands run via Docker Compose (PHP 8.4 and 8.5 containers). Use `make` to see all targets.

```bash
# Run tests (both PHP versions)
make php-tests

# Run tests for a single PHP version
make php-8.4-tests
make php-8.5-tests

# Run a single test file directly
docker compose run --rm php-8.5 ./vendor/bin/phpunit tests/Moment/CompareToTest.php

# Run a single test method
docker compose run --rm php-8.5 ./vendor/bin/phpunit --filter test_method_name tests/Moment/CompareToTest.php

# Code style fix + Psalm static analysis
make php-code-validation

# Mutation testing (requires 100% MSI)
make php-mutation-testing

# Full verification (code validation + tests + mutation testing)
make verify

# Install dependencies
make install
```

## Architecture

### Value Object Hierarchy

- **`Moment`** — wraps `DateTimeImmutable`, represents a specific point in time (always UTC). Primary entry point with `fromString()`, `fromStringInTimeZone()`, `fromDateTime()`.
- **`Date`** — composed of `Month` + `Day`. No timezone, no time component.
- **`Month`** — composed of `Year` + month int (1-12).
- **`Year`** — single int value.
- **`Day`** — single int value (1-31).
- **`Time`** — hour/minute/second/microsecond.
- **`Weekday`** / **`Weekdays`** — day-of-week enum-like values.

All value objects implement `StringNormalizable` / `NullableStringDenormalizable` (from `digital-craftsman/self-aware-normalizers`) for Symfony serializer integration, and `NormalizableTypeWithSQLDeclaration` for Doctrine type integration.

### Comparison Pattern

Each value object has comparison methods (`isAfter`, `isBefore`, `isEqualTo`, etc.) and assertion methods (`mustBeAfter`, `mustBeBefore`, etc.) that throw typed exceptions from `src/Exception/`. The exception classes follow the naming pattern `{Type}Is{Condition}` (e.g., `MomentIsAfter`, `DateIsBefore`). Assertion methods accept a custom exception class parameter to allow domain-specific exceptions.

### Timezone-Aware Operations

`Moment` provides `*InTimeZone` method variants (e.g., `modifyInTimeZone`, `isBeforeInTimeZone`) that accept a `\DateTimeZone` parameter. These convert internally for the operation, keeping the result in UTC.

### Integrations

- **Doctrine types** in `src/Doctrine/` — one type per value object, auto-registered via `DoctrineTypeRegisterCompilerPass`.
- **Symfony bundle** — `DateTimePrecisionBundle` with `DateTimePrecisionExtension`.
- **Clock** — `Clock` interface with `SystemClock` (production) and `FrozenClock` (testing), autowired by the bundle.

## Code Style

- PHP CS Fixer with `@Symfony` ruleset (config in `.php-cs-fixer.dist.php`)
- Test method names use **snake_case** (enforced by php-cs-fixer)
- No Yoda comparisons
- Psalm for static analysis (config in `psalm.xml`)
- Mutation testing via Infection with **100% MSI required**

## Test Structure

Tests mirror the source structure: `tests/{ValueObject}/{MethodName}Test.php`. Custom test exception classes live in `tests/Test/Exception/`.
