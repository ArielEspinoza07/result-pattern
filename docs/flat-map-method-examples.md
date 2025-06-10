# FlatMap Method Examples

This document demonstrates how to use the `flatMap` method of the Result pattern to transform a Success result into another Result (either Success or Failure).

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

## FlatMapping Success to Success

The `flatMap` method allows you to transform a Success result into another Result. Unlike `map`, which returns a Success with the transformed value, `flatMap` returns the Result that your transformation function returns:

```php
// Transform Success into another Success
$flatMappedSuccess = $success->flatMap(function ($value) {
    $value['data'] = ['flatMapped' => true];
    return Result::success($value);
});

// Original success value remains unchanged:
// Array(
//     [status] => 200
//     [message] => OK
//     [data] => Array()
// )

// FlatMapped success value contains the transformed data:
// Array(
//     [status] => 200
//     [message] => OK
//     [data] => Array(
//         [flatMapped] => true
//     )
// )
```

## FlatMapping Success to Failure

You can also use `flatMap` to convert a Success result into a Failure result:

```php
// Transform Success into a Failure
$flatMappedToFailure = $success->flatMap(function ($value) {
    return Result::failure('Converted to failure');
});

// The result is now a Failure with the specified error:
// "Converted to failure"
```

## FlatMapping Failure Results

When you call `flatMap` on a Failure result, the transformation function is not applied, and the original Failure result is returned unchanged:

```php
// Try to transform a Failure result
$flatMappedFailure = $failure->flatMap(function ($value) {
    return Result::success('This will not be executed');
});

// Original failure error:
// Array(
//     [status] => 404
//     [message] => Not Found
// )

// FlatMapped failure remains unchanged:
// Array(
//     [status] => 404
//     [message] => Not Found
// )
```

The `flatMap` method is particularly useful for chaining operations that might fail. For example, you can use it to perform a sequence of operations where each operation depends on the success of the previous one, and any failure short-circuits the chain.
