# Basic Success and Failure Examples

This document demonstrates how to create and use basic Success and Failure objects with the Result pattern.

## Creating a Success Result

```php
use ArielEspinoza07\ResultPattern\Enums\HttpResponseStatusCode;
use ArielEspinoza07\ResultPattern\Result;

// Create a Success result with some data
$success = Result::success([
    'status' => HttpResponseStatusCode::OK->value,
    'message' => HttpResponseStatusCode::OK->message(),
    'data' => [],
]);
```

## Accessing Success Properties

```php
// Get the value from a Success result
$value = $success->getValue();
// Array(
//     [status] => 200
//     [message] => OK
//     [data] => Array()
// )

// Check if it's a Success
$isSuccess = $success->isSuccess(); // true

// Check if it's a Failure
$isFailure = $success->isFailure(); // false
```

## Creating a Failure Result

```php
// Create a Failure result with an error
$failure = Result::failure([
    'status' => HttpResponseStatusCode::NotFound->value,
    'message' => HttpResponseStatusCode::NotFound->message(),
]);
```

## Accessing Failure Properties

```php
// Get the error from a Failure result
$error = $failure->getError();
// Array(
//     [status] => 404
//     [message] => Not Found
// )

// Check if it's a Success
$isSuccess = $failure->isSuccess(); // false

// Check if it's a Failure
$isFailure = $failure->isFailure(); // true
```
