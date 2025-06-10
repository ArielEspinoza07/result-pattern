# Map Method Examples

This document demonstrates how to use the `map` method of the Result pattern to transform the value inside a Success result.

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

## Mapping Success Results

The `map` method allows you to transform the value inside a Success result without unwrapping and rewrapping it:

```php
// Transform the value inside the Success result
$mappedSuccess = $success->map(function ($value) {
    $value['data'] = ['mapped' => true];
    return $value;
});

// Original success value remains unchanged:
// Array(
//     [status] => 200
//     [message] => OK
//     [data] => Array()
// )

// Mapped success value contains the transformed data:
// Array(
//     [status] => 200
//     [message] => OK
//     [data] => Array(
//         [mapped] => true
//     )
// )
```

## Mapping Failure Results

When you call `map` on a Failure result, the transformation function is not applied, and the original Failure result is returned unchanged:

```php
// Try to transform a Failure result
$mappedFailure = $failure->map(function ($value) {
    return 'This transformation will not be applied';
});

// Original failure error:
// Array(
//     [status] => 404
//     [message] => Not Found
// )

// Mapped failure remains unchanged:
// Array(
//     [status] => 404
//     [message] => Not Found
// )
```

The `map` method is useful when you need to transform the data inside a Success result without changing its type. It follows the functional programming principle of immutability, where the original Result is not modified, but a new Result is returned with the transformed value.
