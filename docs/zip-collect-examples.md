# zip() and collect() Examples

This document demonstrates `zip()` and `collect()` and the key semantic difference between them: **fail-fast** vs **fail-all**.

## zip() — fail-fast

`zip()` takes any number of `Result` arguments. As soon as one is a `Failure`, it returns that `Failure` immediately without inspecting the rest.

```php
use ArielEspinoza07\ResultPattern\Result;
use ArielEspinoza07\ResultPattern\Results;

$a = Results::success(1);
$b = Results::success(2);
$c = Results::success(3);

$result = Results::zip($a, $b, $c);

// All succeeded → Success([1, 2, 3])
$result->isSuccess(); // true
$result->getValue();  // [1, 2, 3]
```

### First failure short-circuits

```php
$a = Results::success(1);
$b = Results::failure('b failed');
$c = Results::failure('c also failed');

$result = Results::zip($a, $b, $c);

// Stops at $b, $c is never inspected
$result->isFailure(); // true
$result->getError();  // 'b failed'
```

## collect() — fail-all

`collect()` accepts a plain `array` of `Result` objects. Unlike `zip()`, it processes **every** element regardless of failures, then:

- If all succeeded → returns `Success` with an array of all values
- If any failed → returns `Failure` with an **array of all errors**

Keys are preserved on both sides: each value or error sits at the key of the input that produced it.

```php
$results = [
    Results::success(1),
    Results::success(2),
    Results::success(3),
];

$result = Results::collect($results);

// All succeeded → Success([1, 2, 3])
$result->isSuccess(); // true
$result->getValue();  // [1, 2, 3]
```

### All errors collected at once

```php
$results = [
    Results::success(1),
    Results::failure('required'),
    Results::failure('too short'),
];

$result = Results::collect($results);

$result->isFailure(); // true
$result->getError();  // [1 => 'required', 2 => 'too short']
```

## Practical example: validate multiple fields and report all errors

```php
/** @return Result<string, string> */
function validateName(string $name): Result
{
    return $name !== ''
        ? Results::success($name)
        : Results::failure('cannot be empty');
}

/** @return Result<int, string> */
function validateAge(int $age): Result
{
    return $age >= 18
        ? Results::success($age)
        : Results::failure('must be 18 or older');
}

/** @return Result<string, string> */
function validateEmail(string $email): Result
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false
        ? Results::success($email)
        : Results::failure('invalid format');
}

$result = Results::collect([
    'name' => validateName('Ariel'),
    'age' => validateAge(15),
    'email' => validateEmail('not-an-email'),
]);

// Every failure is returned together, keyed by field
$result->isFailure(); // true
$result->getError();
// [
//   'age' => 'must be 18 or older',
//   'email' => 'invalid format',
// ]

// On success, the values keep their field names too
Results::collect([
    'name' => validateName('Ariel'),
    'age' => validateAge(30),
])->getValue(); // ['name' => 'Ariel', 'age' => 30]
```

This is the primary advantage of `collect()` over `zip()`: the caller receives every error in a single pass,
already keyed by field, which maps directly onto form validation responses.
