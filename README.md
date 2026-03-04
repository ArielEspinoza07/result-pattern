# Result Pattern

<p>
  <a href="https://github.com/ArielEspinoza07/result-pattern/actions">
    <img src="https://github.com/ArielEspinoza07/result-pattern/actions/workflows/tests.yml/badge.svg"  alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/arielespinoza07/result-pattern">
    <img src="https://img.shields.io/packagist/dt/arielespinoza07/result-pattern.svg?style=flat-square" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/arielespinoza07/result-pattern">
    <img src="https://img.shields.io/packagist/v/arielespinoza07/result-pattern.svg?style=flat-square" alt="Latest Stable Version">
  </a>
  <a href="https://github.com/ArielEspinoza07/result-pattern/blob/main/LICENSE">
    <img src="https://img.shields.io/badge/license-MIT-green.svg" alt="License">
  </a>
</p>

---

A modern, immutable implementation of the Result pattern for PHP 8.3+.

> **Requires [PHP 8.3+](https://php.net/releases/)**

---

## Features

- Type-safe result handling with strict type hints and PHPStan level max
- Immutable objects using PHP 8.3+ `readonly` classes
- Fluent, chainable API: `map → flatMap → recover → fold`
- Full generic type inference via `@template` annotations
- Comprehensive test suite with Pest PHP and type coverage

---

## Project Structure

```
src/
├── Failure.php
├── Success.php
└── Result.php
```

---

## Installation

```bash
composer require arielespinoza07/result-pattern
```

---

## Quick Start

```php
use ArielEspinoza07\ResultPattern\Result;

// Create results
$ok  = Result::success(42);
$err = Result::failure('something went wrong');

// Wrap a throwing operation
$result = Result::attempt(fn () => riskyOperation());

// Convert nullable to Result
$result = Result::fromNullable($user, new UserNotFoundException());

// Transform and compose
$value = Result::success(2)
    ->map(fn ($x) => $x * 10)
    ->flatMap(fn ($x) => Result::success($x + 5))
    ->getValueOr(0); // 25

// Handle both branches
$output = $result->fold(
    onSuccess: fn ($v) => "Got: {$v}",
    onFailure: fn ($e) => "Error: {$e}",
);
```

---

## API Reference

### Static constructors

| Method | Description |
|--------|-------------|
| `Result::success($value)` | Wraps a value in a `Success` |
| `Result::failure($error)` | Wraps an error in a `Failure` |
| `Result::attempt(callable, array $only = [])` | Executes a callable; catches `Throwable` as `Failure`. Pass `$only` to catch only specific exception types. |
| `Result::fromNullable($value, $error)` | `null` → `Failure($error)`, non-null → `Success($value)` |
| `Result::zip(Result ...$results)` | All succeed → `Success([values])`, first failure wins (fail-fast) |
| `Result::collect(array $results)` | Processes all results; returns `Failure([errors])` with every error collected (fail-all) |

### Instance methods

| Method | Description |
|--------|-------------|
| `isSuccess()` | `true` if `Success` |
| `isFailure()` | `true` if `Failure` |
| `getValue()` | Returns value (throws on `Failure`) — prefer `getValueOr()` |
| `getError()` | Returns error (throws on `Success`) — prefer `getErrorOr()` |
| `getValueOr($default)` | Safe value access with fallback |
| `getErrorOr($default)` | Safe error access with fallback |
| `toNullable()` | `Success($v)` → `$v`, `Failure` → `null` |
| `map(callable)` | Transform the value; no-op on `Failure` |
| `mapError(callable)` | Transform the error; no-op on `Success` |
| `flatMap(callable)` | Chain a `Result`-returning callable on `Success` |
| `flatMapError(callable)` | Chain a `Result`-returning callable on `Failure` |
| `recover(callable)` | Convert `Failure` → `Success` via fallback value |
| `recoverWith(callable)` | Convert `Failure` → `Result` (recovery can itself fail) |
| `tap(callable)` | Run a side-effect on `Success` without modifying the result |
| `onSuccess(callable)` | Run a side-effect on `Success` |
| `onFailure(callable)` | Run a side-effect on `Failure` |
| `fold(onSuccess, onFailure)` | Collapse both branches into a single value |

---

## Documentation

- [Basic Success and Failure Examples](docs/basic-examples.md)
- [attempt() / try() Method Examples](docs/try-method-examples.md)
- [zip() and collect() Examples](docs/zip-collect-examples.md)
- [fromNullable() Examples](docs/from-nullable-examples.md)
- [onSuccess and onFailure Examples](docs/on-success-failure-examples.md)
- [tap() and toNullable() Examples](docs/tap-to-nullable-examples.md)
- [Map Method Examples](docs/map-method-examples.md)
- [mapError() and flatMapError() Examples](docs/map-error-examples.md)
- [FlatMap Method Examples](docs/flat-map-method-examples.md)
- [Fold Method Examples](docs/fold-method-examples.md)
- [recover() and recoverWith() Examples](docs/recover-examples.md)
- [Error Handling Examples](docs/error-handling-examples.md)

---

## Development

### Requirements

- PHP 8.3+
- Composer 2.0+

### Setup

```bash
git clone https://github.com/ArielEspinoza07/result-pattern.git
cd result-pattern
composer install
```

### Quality Tools

```bash
composer check       # lint + analyse + test (all-in-one)
composer lint        # check code style (Pint)
composer lint:fix    # fix code style
composer analyse     # static analysis (PHPStan level max)
composer test        # run tests (Pest PHP)
composer test:coverage # run tests with coverage report
```

---

## Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md) for setup instructions, code conventions, and PR guidelines.

---

## License

[MIT License](LICENSE)
