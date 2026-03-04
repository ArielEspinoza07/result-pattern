# mapError() and flatMapError() Examples

This document demonstrates how to transform the **error** side of a `Result` using `mapError()` and `flatMapError()`.

## mapError()

`mapError()` applies a callable to the error value of a `Failure` and returns a new `Failure` with the transformed error. It is a no-op on `Success`.

```php
use ArielEspinoza07\ResultPattern\Result;

$result = Result::failure(['code' => 404, 'detail' => 'Not Found'])
    ->mapError(fn ($error) => 'Error ' . $error['code'] . ': ' . $error['detail']);

$result->isFailure(); // true
$result->getError();  // 'Error 404: Not Found'
```

### No-op on Success

```php
$result = Result::success(42)
    ->mapError(fn ($error) => 'transformed');

$result->getValue(); // 42 — callable is never invoked
```

### Normalising error shapes

```php
// Convert a raw exception into a structured error array
$result = Result::attempt(fn () => riskyOperation())
    ->mapError(fn (\Throwable $e) => [
        'message' => $e->getMessage(),
        'code'    => $e->getCode(),
    ]);
```

## flatMapError()

`flatMapError()` is the error-side equivalent of `flatMap()`. The callable receives the error and must return a `Result`. This lets you recover or re-map in a single step.

```php
$result = Result::failure('temporary error')
    ->flatMapError(function (string $error): Result {
        if ($error === 'temporary error') {
            return Result::success('recovered value');
        }

        return Result::failure('permanent error');
    });

$result->isSuccess(); // true
$result->getValue();  // 'recovered value'
```

### Re-mapping to a different Failure

```php
$result = Result::failure('DB_CONN_TIMEOUT')
    ->flatMapError(fn ($code) => Result::failure("Database unavailable (code: {$code})"));

$result->getError(); // 'Database unavailable (code: DB_CONN_TIMEOUT)'
```

### No-op on Success

```php
$result = Result::success(42)
    ->flatMapError(fn ($error) => Result::failure('never runs'));

$result->getValue(); // 42
```
