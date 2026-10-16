# Error Handling Examples

This document demonstrates how exceptions are thrown when trying to access invalid properties of Result objects.

## Setup

```php
use ArielEspinoza07\ResultPattern\Results;

// Create a Success result
$success = Results::success(['status' => 200, 'message' => 'OK', 'data' => []]);

// Create a Failure result
$failure = Results::failure(['status' => 404, 'message' => 'Not Found']);
```

## Accessing Value on Failure

When you try to access the value of a Failure result using `getValue()`, an `InvalidResultAccessException` is thrown.
It extends `LogicException`, because reading a side that does not exist is a programming error, not a runtime condition:

```php
use ArielEspinoza07\ResultPattern\Exceptions\InvalidResultAccessException;

try {
    $failure->getValue();
} catch (InvalidResultAccessException $e) {
    echo $e->getMessage(); // "Cannot get the value of a Failure (error type: array)."
}
```

If the Failure's error is itself a `Throwable`, it is attached as the previous exception, so the original
message and stack trace show up in your logs:

```php
$failure = Results::attempt(fn () => $db->query('...')); // throws PDOException

$failure->getValue();
// InvalidResultAccessException: Cannot get the value of a Failure (error type: PDOException).
// Caused by: PDOException: SQLSTATE[HY000] ...
```

## Accessing Error on Success

Similarly, when you try to access the error of a Success result using `getError()`, an `InvalidResultAccessException` is thrown:

```php
try {
    $success->getError();
} catch (InvalidResultAccessException $e) {
    echo $e->getMessage(); // "Cannot get the error of a Success (value type: array)."
}
```

## Best Practices

To avoid these exceptions, always check the type of the Result before accessing its properties:

```php
// Safe way to access values
if ($result->isSuccess()) {
    $value = $result->getValue();
    // Process the value
} else {
    $error = $result->getError();
    // Handle the error
}
```

Alternatively, use the `fold` method to handle both cases safely:

```php
$output = $result->fold(
    function ($value) {
        // Handle success case
        return processValue($value);
    },
    function ($error) {
        // Handle error case
        return handleError($error);
    }
);
```

This approach eliminates the need for conditional checks and ensures that you're always accessing the appropriate property.
