# attempt() / try() Method Examples

This document demonstrates how to use `attempt()` to handle operations that might throw exceptions.

> **Note:** `try()` is deprecated in favour of `attempt()`. The name `try` conflicts with a PHP reserved keyword and causes IDE friction. Use `attempt()` in all new code.

## Successful Operation

```php
use ArielEspinoza07\ResultPattern\Result;

// Execute an operation that succeeds
$result = Result::attempt(function (): string {
    return 'Hello!';
});

// Check if it's a Success
$isSuccess = $result->isSuccess(); // true

// Get the value from the successful operation
$value = $result->getValue(); // "Hello!"
```

## Failed Operation

```php
// Execute an operation that throws an exception
$result = Result::attempt(function (): never {
    throw new RuntimeException('Boom! Something went wrong.');
});

// Check if it's a Failure
$isFailure = $result->isFailure(); // true

// Get the error message from the exception
$errorMessage = $result->getError()->getMessage(); // "Boom! Something went wrong."
```

The `attempt()` method automatically catches any `Throwable` thrown during the execution of the callback and converts it into a `Failure`. This allows for a more functional approach to error handling without try-catch blocks scattered throughout your code.

## Filtering exceptions with `$only`

By default `attempt()` catches every `Throwable`. Pass an array of exception class names as the second argument to restrict which exceptions are caught. Exceptions outside the filter are re-thrown.

### Catch a single exception type

```php
use ArielEspinoza07\ResultPattern\Result;

$result = Result::attempt(
    fn () => riskyOperation(),
    [RuntimeException::class],
);

// Only RuntimeException (and subclasses) become Failure.
// Any other Throwable propagates normally.
```

### Catch multiple exception types

```php
$result = Result::attempt(
    fn () => riskyDatabaseOperation(),
    [IOException::class, DatabaseException::class],
);

// Catches either IOException or DatabaseException as Failure.
```

### Exception outside the filter is re-thrown

```php
try {
    $result = Result::attempt(
        function (): never {
            throw new \TypeError('wrong type');
        },
        [RuntimeException::class], // TypeError is not in the list
    );
} catch (\TypeError $e) {
    echo 'TypeError was not caught by attempt(): ' . $e->getMessage();
}
```

### Default behaviour — catch everything

```php
// $only defaults to [], which means all Throwables are caught (backward-compatible).
$result = Result::attempt(fn () => riskyOperation());
```

## Deprecated: try()

`Result::try()` is an alias for `attempt()` kept for backwards compatibility. It will be removed in a future major version.

```php
// ❌ Deprecated — avoid in new code
$result = Result::try(fn () => riskyOperation());

// ✅ Preferred
$result = Result::attempt(fn () => riskyOperation());
```
