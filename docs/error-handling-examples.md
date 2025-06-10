# Error Handling Examples

This document demonstrates how exceptions are thrown when trying to access invalid properties of Result objects.

## Setup

```php
use ArielEspinoza07\ResultPattern\Enums\HttpResponseStatusCode;
use ArielEspinoza07\ResultPattern\Result;

// Create a Success result
$success = Result::success([
    'status' => HttpResponseStatusCode::OK->value,
    'message' => HttpResponseStatusCode::OK->message(),
    'data' => [],
]);

// Create a Failure result
$failure = Result::failure([
    'status' => HttpResponseStatusCode::NotFound->value,
    'message' => HttpResponseStatusCode::NotFound->message(),
]);
```

## Accessing Value on Failure

When you try to access the value of a Failure result using `getValue()`, a `RuntimeException` is thrown:

```php
try {
    $failure->getValue();
} catch (RuntimeException $e) {
    // This will catch: "No value in Failure"
    echo 'Caught exception: ' . $e->getMessage();
}
```

## Accessing Error on Success

Similarly, when you try to access the error of a Success result using `getError()`, a `RuntimeException` is thrown:

```php
try {
    $success->getError();
} catch (RuntimeException $e) {
    // This will catch: "No error in Success"
    echo 'Caught exception: ' . $e->getMessage();
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
