# tap() and toNullable() Examples

This document demonstrates `tap()` for side-effects and `toNullable()` for interop with nullable-based code.

## tap()

`tap()` runs a callable on the value of a `Success` **without modifying the result**. The original `Result` is returned unchanged. It is a no-op on `Failure`.

```php
use ArielEspinoza07\ResultPattern\Result;

$result = Result::success(42)
    ->tap(fn ($value) => logger()->info("Got value: {$value}"));

// The result is still Success(42)
$result->getValue(); // 42
```

### Chaining tap() with other methods

```php
$value = Result::attempt(fn () => fetchData())
    ->tap(fn ($data) => cache()->put('key', $data, 60))  // cache on success
    ->map(fn ($data) => transform($data))
    ->getValueOr([]);
```

### No-op on Failure

```php
$result = Result::failure('error')
    ->tap(fn ($value) => logger()->info('never called'));

$result->isFailure(); // true — tap did not run, result unchanged
```

## toNullable()

`toNullable()` unwraps a `Success` to its raw value, or returns `null` for a `Failure`. This is useful when interfacing with code that uses nullable return types.

```php
$result = Result::success('hello');
$result->toNullable(); // 'hello'

$result = Result::failure('error');
$result->toNullable(); // null
```

### Practical example: interop with legacy nullable code

```php
function findUser(int $id): ?User
{
    return Result::attempt(fn () => UserRepository::findOrFail($id))
        ->toNullable();
}

$user = findUser(99);

if ($user !== null) {
    echo "Found: {$user->name}";
} else {
    echo 'User not found';
}
```

### Combining tap() and toNullable()

```php
$user = Result::attempt(fn () => UserRepository::findOrFail($id))
    ->tap(fn ($u) => logger()->info("Loaded user #{$u->id}"))
    ->toNullable();
```
