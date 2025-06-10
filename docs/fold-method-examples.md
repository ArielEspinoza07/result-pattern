# Fold Method Examples

This document demonstrates how to use the `fold` method of the Result pattern to handle both Success and Failure cases with a single return value.

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

## Using Fold with Success Results

The `fold` method takes two callbacks: one for handling Success and one for handling Failure. It returns the result of the appropriate callback based on the Result type:

```php
// Apply fold to a Success result
$successFoldResult = $success->fold(
    // This callback is executed for Success
    function ($value) {
        return 'Success folded: ' . json_encode($value);
    },
    // This callback is skipped for Success
    function ($error) {
        return 'Error folded: ' . json_encode($error);
    }
);

// Result: "Success folded: {"status":200,"message":"OK","data":[]}"
```

## Using Fold with Failure Results

```php
// Apply fold to a Failure result
$failureFoldResult = $failure->fold(
    // This callback is skipped for Failure
    function ($value) {
        return 'Success folded: ' . json_encode($value);
    },
    // This callback is executed for Failure
    function ($error) {
        return 'Error folded: ' . json_encode($error);
    }
);

// Result: "Error folded: {"status":404,"message":"Not Found"}"
```

## Benefits of Using Fold

The `fold` method is particularly useful when you need to:

1. Handle both Success and Failure cases in a single expression
2. Convert a Result into a different type (like a string, number, or another object)
3. Provide default values or fallbacks for Failure cases
4. Standardize error handling across your application

It's a powerful way to eliminate conditional logic and handle both success and error paths in a functional style.
