# fromNullable() Examples

This document demonstrates `Result::fromNullable()`, which converts a nullable value into a `Result`.

## Basic usage

```php
use ArielEspinoza07\ResultPattern\Result;

// null → Failure
$result = Result::fromNullable(null, new \RuntimeException('Value was null'));

$result->isFailure(); // true
$result->getError();  // RuntimeException instance
```

```php
// Non-null → Success
$result = Result::fromNullable('hello', new \RuntimeException('Value was null'));

$result->isSuccess(); // true
$result->getValue();  // 'hello'
```

## With a repository lookup

```php
function findUser(int $id): Result
{
    $user = UserRepository::find($id); // returns User|null

    return Result::fromNullable($user, new UserNotFoundException("User {$id} not found"));
}

$result = findUser(42);

$result->fold(
    onSuccess: fn ($user) => "Welcome, {$user->name}!",
    onFailure: fn ($e)    => "Error: {$e->getMessage()}",
);
```

## Falsy values that are NOT null remain Success

Only a strict `null` triggers `Failure`. PHP falsy values like `false`, `0`, and `''` are treated as valid values:

```php
Result::fromNullable(false, 'error')->isSuccess(); // true  — false is not null
Result::fromNullable(0,     'error')->isSuccess(); // true  — 0 is not null
Result::fromNullable('',    'error')->isSuccess(); // true  — '' is not null
Result::fromNullable(null,  'error')->isFailure(); // true  — only null triggers Failure
```

## Error can be any type

The `$error` argument accepts any value, not just exceptions:

```php
$result = Result::fromNullable(null, 'record not found');
$result->getError(); // 'record not found'

$result = Result::fromNullable(null, ['code' => 404, 'message' => 'Not Found']);
$result->getError(); // ['code' => 404, 'message' => 'Not Found']
```
