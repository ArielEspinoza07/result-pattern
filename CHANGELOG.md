# Changelog

## [Unreleased]

### Docs
- `SECURITY.md`: `3.x` is now the only supported version.
- README and CONTRIBUTING describe `composer test:coverage` as the type coverage check.

---

## [3.0.0] - 2026-10-16

### Breaking
- Static constructors and combinators moved from `Result` to the new final class `Results`:
  replace `Result::success|failure|attempt|fromNullable|zip|collect(...)` with `Results::…(...)`.
  `Result` is now only the type: keep using it in type hints and `@return Result<T, E>` docblocks.
- Removed `try()`: use `Results::attempt()`.
- Removed `tap()`: use `onSuccess()`.
- Removed `flatMapError()`: use `recoverWith()` (identical behavior).
- Removed `toNullable()`: use `getValueOr(null)`.
- `Results::success()` / `Results::failure()` now declare `Success<T>` / `Failure<E>` as their return types.
- `getValue()` on a `Failure` and `getError()` on a `Success` throw
  `Exceptions\InvalidResultAccessException` (extends `LogicException`) instead of `RuntimeException`.
  Code that catches `RuntimeException` around these calls must catch the new exception instead.
  When the Failure's error is a `Throwable`, it is attached as the previous exception.
- `Results::collect()` preserves array keys on both sides. Errors stay at the key of the input that produced them
  (`['email' => 'invalid']`), and list input yields errors at their original index (`[1 => 'e1', 3 => 'e2']`)
  instead of being renumbered.

### Changed
- Generic templates are covariant, so `Success<int>` and `Failure<string>` are accepted where
  `Result<int, string>` is expected. Previously this failed PHPStan at level max.
- `flatMap()` accepts a callback with a different error type; the resulting error type widens to `TError|TNewError`.
- `onSuccess()` / `onFailure()` accept callbacks that return a value (the return value is ignored).
- `isSuccess()` / `isFailure()` narrow the result to `Success` / `Failure` for PHPStan.
- `Result` is declared `@phpstan-sealed Success|Failure`.
- `zip()` and `collect()` infer value and error types from their arguments.
- `recover()` declares `Success` as its return type.
- `Failure::getValue()` and `Success::getError()` declare a `never` return type, so PHPStan treats
  code after them as unreachable.
- Exception messages name the type of the value or error that was present
  (`Cannot get the value of a Failure (error type: PDOException).`), never its contents.

### Added
- `Results` final class holding the named constructors (`success`, `failure`, `attempt`, `fromNullable`)
  and combinators (`zip`, `collect`).
- `Exceptions\InvalidResultAccessException` with named constructors `valueOfFailure()` and `errorOfSuccess()`.

### Docs
- README: new project structure, Quick Start with a typed `Result` return, and API tables split into
  `Results` (constructors and combinators) and `Result` (instance methods).
- `getValueOr()` docblock notes that the default is evaluated eagerly and points to `recover()` for costly defaults.
- Renamed `docs/try-method-examples.md` to `docs/attempt-method-examples.md` and removed the `try()` section.
- Removed `docs/tap-to-nullable-examples.md`; removed the `flatMapError()` section from `docs/map-error-examples.md`.
- `docs/error-handling-examples.md` documents `InvalidResultAccessException` and previous-exception chaining.
- `docs/zip-collect-examples.md` shows key-preserving `collect()` with per-field validation.
- All examples use `Results::` for construction.

### Development
- Removed every `@phpstan-ignore` from `src/` and `tests/`; enabled `reportUnmatchedIgnoredErrors`
  and dropped the obsolete PHPUnit ignore pattern.
- Added `tests/Types/ResultTypes.php`: `assertType` checks for the inferred types of the public API.
- `composer test:coverage` runs type coverage (`pest --type-coverage --min=100`).
- Replaced the `Formats` and `Tests` workflows with a single `CI` workflow: on every pull request and on pushes
  to `main`, one quality job (composer validate, Pint, PHPStan, type coverage) on PHP 8.3, plus tests on
  PHP 8.3/8.4/8.5 with lowest and stable dependencies on Ubuntu.
- Removed the unused changelog and release workflows and their scripts.

---

## [2.2.0] - 2026-03-04

### Added
- `attempt(callable, array $only = [])`: optional `$only` parameter to filter which exception
  types are caught; exceptions outside the list are re-thrown
- `collect(array $results)` redesigned as fail-all accumulator: processes every element and
  returns `Failure` with an array of **all** errors instead of short-circuiting on the first failure
- `getValueOr($default)` / `getErrorOr($default)`: safe value/error access with a fallback
- `mapError(callable)`: transform the error side; no-op on `Success`
- `recover(callable)`: convert `Failure` → `Success` using a fallback callable
- `fromNullable($value, $error)`: `null` → `Failure($error)`, non-null → `Success($value)`
- `zip(Result ...$results)`: fail-fast combinator — returns first `Failure` or `Success([values])`
- `flatMapError(callable)`: chain a `Result`-returning callable on the `Failure` side
- `recoverWith(callable)`: like `recover()` but the callable may itself return a `Failure`
- `tap(callable)`: run a side-effect on `Success` without modifying the result
- `toNullable()`: `Success($v)` → `$v`, `Failure` → `null`
- PHP 8.5 added to GitHub Actions test matrix

### Changed
- Deprecated `Result::try()` in favour of `Result::attempt()`
- Removed unused `HttpResponseStatusCode` enum
- Removed `rector`, `mockery`, and `peck` dev dependencies
- PHPStan now also analyses test files; updated Pint code style rules

### Docs
- Added examples for `attempt($only)`, `zip()` / `collect()`, `fromNullable()`,
  `tap()` / `toNullable()`, `mapError()` / `flatMapError()`, `recover()` / `recoverWith()`
- Updated existing docs to remove `HttpResponseStatusCode` enum references

---

## [2.1.0] - 2025-08-08

### Added
- Automated release and changelog GitHub Actions workflow
- `http-response-code.md` documentation page

### Changed
- Updated GitHub Actions configuration and dependencies

### Fixed
- Fixed changelog generation script

---

## [2.0.0] - 2025-06-10

### Added
- New `Result`, `Success`, `Failure` class hierarchy replacing the old `Ok` / `Failed` design
- `Result::success($value)` and `Result::failure($error)` static constructors
- `Result::try(callable)`: wraps an exception-throwing callable into a `Result`
- Instance methods: `isSuccess()`, `isFailure()`, `getValue()`, `getError()`,
  `map()`, `flatMap()`, `fold()`, `onSuccess()`, `onFailure()`
- Documentation examples for `map`, `flatMap`, `fold`, `onSuccess` / `onFailure`, error handling

### Changed
- Complete rewrite: replaced `Contracts/` directory and `Ok` / `Failed` classes with a unified
  `Result` / `Success` / `Failure` design
- Removed all docblocks from source classes
- Automated changelog generation via `generate-changelog.sh` script

### Fixed
- Fixed linting issues (Pint)
- Moved tests to top level (removed nested `describe` blocks)

---

## [1.0.2] - 2025-06-09

### Changed
- Improved GitHub Actions release workflow configuration

---

## [1.0.1] - 2025-06-09

### Changed
- Updated README

---

## [1.0.0] - 2025-06-09

### Added
- Initial `Result` pattern implementation for PHP 8.3+
- `Result`, `Ok`, `Failed` classes with `Contracts` directory
- PHPStan static analysis at level max
- Pest PHP test suite (migrated from PHPUnit)
- GitHub Actions CI workflow
- MIT license
- Composer scripts: `check`, `lint`, `lint:fix`, `analyse`, `test`, `test:coverage`
- Rector for automated refactoring

### Changed
- Enhanced type safety with strict type hints and `readonly` classes

[Unreleased]: https://github.com/arielespinoza07/result-pattern/compare/v3.0.0...HEAD
[3.0.0]: https://github.com/arielespinoza07/result-pattern/compare/v2.2.0...v3.0.0
[2.2.0]: https://github.com/arielespinoza07/result-pattern/compare/v2.1.0...v2.2.0
[2.1.0]: https://github.com/arielespinoza07/result-pattern/compare/v2.0.0...v2.1.0
[2.0.0]: https://github.com/arielespinoza07/result-pattern/compare/v1.0.2...v2.0.0
[1.0.2]: https://github.com/arielespinoza07/result-pattern/compare/v1.0.1...v1.0.2
[1.0.1]: https://github.com/arielespinoza07/result-pattern/compare/v1.0.0...v1.0.1
[1.0.0]: https://github.com/arielespinoza07/result-pattern/releases/tag/v1.0.0