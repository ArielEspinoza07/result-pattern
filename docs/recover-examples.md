# recover() and recoverWith() Examples

This document demonstrates how to convert a `Failure` back into a `Success` using `recover()` and `recoverWith()`.

## recover()

`recover()` calls the provided callable with the error value and wraps the return value in a `Success`. It is a no-op on an already-`Success` result.

```php
use ArielEspinoza07\ResultPattern\Result;

$result = Result::failure('something went wrong')
    ->recover(fn ($error) => 'default value');

$result->isSuccess(); // true
$result->getValue();  // 'default value'
```

### No-op on Success

```php
$result = Result::success(42)
    ->recover(fn ($error) => 0);

$result->getValue(); // 42 — the callable is never invoked
```

## recoverWith()

`recoverWith()` is like `recover()` but the callable must return a `Result`. This allows the recovery itself to fail.

```php
$result = Result::failure('primary source unavailable')
    ->recoverWith(fn ($error) => Result::success('value from fallback source'));

$result->isSuccess(); // true
$result->getValue();  // 'value from fallback source'
```

### Recovery that itself fails

```php
$result = Result::failure('primary source unavailable')
    ->recoverWith(fn ($error) => Result::failure('fallback source also unavailable'));

$result->isFailure(); // true
$result->getError();  // 'fallback source also unavailable'
```

## Practical example: retry with another data source

```php
function fetchFromPrimary(int $id): Result
{
    return Result::attempt(fn () => primaryDb()->find($id));
}

function fetchFromReplica(int $id): Result
{
    return Result::attempt(fn () => replicaDb()->find($id));
}

$user = fetchFromPrimary(42)
    ->recoverWith(fn ($error) => fetchFromReplica(42))
    ->getValueOr(null);
```

If the primary database throws, `recoverWith()` transparently tries the replica. If the replica also fails, the final result is a `Failure`.
