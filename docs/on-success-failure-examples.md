# onSuccess and onFailure Examples

This document demonstrates how to use the `onSuccess` and `onFailure` methods of the Result pattern to execute callbacks based on the result type.

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

## Using onSuccess

```php
// This callback will be executed because $success is a Success result
$success->onSuccess(function ($value) {
    // Do something with the value
    // For example: log the success, send a notification, etc.

    // Output would be the success value:
    // Array(
    //     [status] => 200
    //     [message] => OK
    //     [data] => Array()
    // )
});

// This callback will NOT be executed because $failure is not a Success result
$failure->onSuccess(function ($value) {
    // This code will be skipped
});
```

## Using onFailure

```php
// This callback will NOT be executed because $success is not a Failure result
$success->onFailure(function ($error) {
    // This code will be skipped
});

// This callback will be executed because $failure is a Failure result
$failure->onFailure(function ($error) {
    // Do something with the error
    // For example: log the error, send an alert, etc.

    // Output would be the error value:
    // Array(
    //     [status] => 404
    //     [message] => Not Found
    // )
});
```

## Chaining Callbacks

Both `onSuccess` and `onFailure` methods return the original Result object, allowing you to chain multiple callbacks:

```php
$success
    ->onSuccess(function ($value) {
        // First callback
        // This will be executed
    })
    ->onSuccess(function ($value) {
        // Second callback
        // This will also be executed
    });
```

This chaining capability makes it easy to perform multiple operations on a Result without nesting callbacks.
