# Result Pattern

<p>
  <a href="https://github.com/ArielEspinoza07/result-pattern/actions">
    <img src="https://github.com/ArielEspinoza07/result-pattern/actions/workflows/ci.yml/badge.svg"  alt="Build Status">
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
├── Result.php    # the type: abstract, sealed to Success|Failure, all instance methods
├── Success.php
├── Failure.php
├── Results.php   # named constructors and combinators
└── Exceptions/
    └── InvalidResultAccessException.php
```

`Result` is the type you type-hint. `Results` is where results come from.

---

## Installation

```bash
composer require arielespinoza07/result-pattern
```

---

## Quick Start

```php
use ArielEspinoza07\ResultPattern\Result;
use ArielEspinoza07\ResultPattern\Results;

/** @return Result<User, UserNotFound> */
function findUser(int $id): Result
{
    return Results::fromNullable(User::find($id), new UserNotFound($id));
}

// Create results
$ok  = Results::success(42);
$err = Results::failure('something went wrong');

// Wrap a throwing operation
$result = Results::attempt(fn () => riskyOperation());

// Transform and compose
$value = Results::success(2)
    ->map(fn ($x) => $x * 10)
    ->flatMap(fn ($x) => Results::success($x + 5))
    ->getValueOr(0); // 25

// Handle both branches
$output = $result->fold(
    onSuccess: fn ($v) => "Got: {$v}",
    onFailure: fn ($e) => "Error: {$e}",
);
```

---

## API Reference

### `Results`: constructors and combinators

| Method | Description |
|--------|-------------|
| `Results::success($value)` | Wraps a value in a `Success` |
| `Results::failure($error)` | Wraps an error in a `Failure` |
| `Results::attempt(callable, array $only = [])` | Executes a callable; catches `Throwable` as `Failure`. Pass `$only` to catch only specific exception types. |
| `Results::fromNullable($value, $error)` | `null` → `Failure($error)`, non-null → `Success($value)` |
| `Results::zip(Result ...$results)` | All succeed → `Success([values])`, first failure wins (fail-fast) |
| `Results::collect(array $results)` | Processes all results; returns `Failure([errors])` with every error collected (fail-all). Keys are preserved, so errors stay matched to their input |

### `Result`: instance methods

| Method | Description |
|--------|-------------|
| `isSuccess()` | `true` if `Success`; narrows the type for PHPStan |
| `isFailure()` | `true` if `Failure`; narrows the type for PHPStan |
| `getValue()` | Returns value (throws `InvalidResultAccessException` on `Failure`) — prefer `getValueOr()` |
| `getError()` | Returns error (throws `InvalidResultAccessException` on `Success`) — prefer `getErrorOr()` |
| `getValueOr($default)` | Safe value access with fallback (`getValueOr(null)` for nullable interop) |
| `getErrorOr($default)` | Safe error access with fallback |
| `map(callable)` | Transform the value; no-op on `Failure` |
| `mapError(callable)` | Transform the error; no-op on `Success` |
| `flatMap(callable)` | Chain a `Result`-returning callable on `Success`; the error type widens |
| `recover(callable)` | Convert `Failure` → `Success` via fallback value |
| `recoverWith(callable)` | Convert `Failure` → `Result` (recovery can itself fail) |
| `onSuccess(callable)` | Run a side effect on `Success`; returns the same result |
| `onFailure(callable)` | Run a side effect on `Failure`; returns the same result |
| `fold(onSuccess, onFailure)` | Collapse both branches into a single value |

---

## Documentation

- [Basic Success and Failure Examples](docs/basic-examples.md)
- [attempt() Method Examples](docs/attempt-method-examples.md)
- [zip() and collect() Examples](docs/zip-collect-examples.md)
- [fromNullable() Examples](docs/from-nullable-examples.md)
- [onSuccess and onFailure Examples](docs/on-success-failure-examples.md)
- [Map Method Examples](docs/map-method-examples.md)
- [mapError() Examples](docs/map-error-examples.md)
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
composer test:coverage # type coverage (must stay at 100%)
```

---

## Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md) for setup instructions, code conventions, and PR guidelines.

---

## License

[MIT License](LICENSE)
