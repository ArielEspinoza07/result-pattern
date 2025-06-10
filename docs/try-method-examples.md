# Try Method Examples

This document demonstrates how to use the `try` method of the Result pattern to handle operations that might throw exceptions.

## Successful Operation

```php
use ArielEspinoza07\ResultPattern\Result;

// Execute an operation that succeeds
$successTry = Result::try(function (): string {
    return 'Hello!';
});

// Check if it's a Success
$isSuccess = $successTry->isSuccess(); // true

// Get the value from the successful operation
$value = $successTry->getValue(); // "Hello!"
```

## Failed Operation

```php
// Execute an operation that throws an exception
$failureTry = Result::try(function (): never {
    throw new RuntimeException('Boom! Something went wrong.');
});

// Check if it's a Failure
$isFailure = $failureTry->isFailure(); // true

// Get the error message from the exception
$errorMessage = $failureTry->getError()->getMessage(); // "Boom! Something went wrong."
```

The `try` method automatically catches any exceptions thrown during the execution of the provided callback and converts them into a Failure result. This allows for a more functional approach to error handling without try-catch blocks scattered throughout your code.
