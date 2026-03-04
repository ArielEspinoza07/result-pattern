# zip() and collect() Examples

This document demonstrates `zip()` and `collect()` and the key semantic difference between them: **fail-fast** vs **fail-all**.

## zip() — fail-fast

`zip()` takes any number of `Result` arguments. As soon as one is a `Failure`, it returns that `Failure` immediately without inspecting the rest.

```php
use ArielEspinoza07\ResultPattern\Result;

$a = Result::success(1);
$b = Result::success(2);
$c = Result::success(3);

$result = Result::zip($a, $b, $c);

// All succeeded → Success([1, 2, 3])
$result->isSuccess(); // true
$result->getValue();  // [1, 2, 3]
```

### First failure short-circuits

```php
$a = Result::success(1);
$b = Result::failure('b failed');
$c = Result::failure('c also failed');

$result = Result::zip($a, $b, $c);

// Stops at $b, $c is never inspected
$result->isFailure(); // true
$result->getError();  // 'b failed'
```

## collect() — fail-all

`collect()` accepts a plain `array` of `Result` objects. Unlike `zip()`, it processes **every** element regardless of failures, then:

- If all succeeded → returns `Success` with an array of all values
- If any failed → returns `Failure` with an **array of all errors**

```php
$results = [
    Result::success(1),
    Result::success(2),
    Result::success(3),
];

$result = Result::collect($results);

// All succeeded → Success([1, 2, 3])
$result->isSuccess(); // true
$result->getValue();  // [1, 2, 3]
```

### All errors collected at once

```php
$results = [
    Result::success(1),
    Result::failure('field_a: required'),
    Result::failure('field_b: too short'),
];

$result = Result::collect($results);

$result->isFailure(); // true
$result->getError();  // ['field_a: required', 'field_b: too short']
```

## Practical example: validate multiple fields and report all errors

```php
function validateName(string $name): Result
{
    return $name !== ''
        ? Result::success($name)
        : Result::failure('name: cannot be empty');
}

function validateAge(int $age): Result
{
    return $age >= 18
        ? Result::success($age)
        : Result::failure('age: must be 18 or older');
}

function validateEmail(string $email): Result
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false
        ? Result::success($email)
        : Result::failure('email: invalid format');
}

$result = Result::collect([
    validateName(''),
    validateAge(15),
    validateEmail('not-an-email'),
]);

// All three failures are returned together
$result->isFailure(); // true
$result->getError();
// [
//   'name: cannot be empty',
//   'age: must be 18 or older',
//   'email: invalid format',
// ]
```

This is the primary advantage of `collect()` over `zip()`: the caller receives a complete list of errors in a single pass, which is ideal for form validation and batch operations.
