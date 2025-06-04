# Result Pattern

A modern PHP 8.3+ implementation of the Result pattern for handling operation outcomes and HTTP responses.

## Features

- 🛡️ Type-safe result handling
- 🌐 HTTP response status codes support
- 🔒 Immutable objects using PHP 8.3+ readonly classes
- 🎯 SOLID principles adherence
- 🧩 Composable and extensible design

## Installation

```bash
composer require windsurf/result-pattern
```

## Usage

```php
use Windsurf\ResultPattern\Ok;
use Windsurf\ResultPattern\NotFound;

// Success case
$result = Ok::from("Operation successful", ["id" => 1]);
if ($result->isSuccess()) {
    $data = $result->data();
}

// Error case
$result = NotFound::from("Resource not found");
echo $result->message(); // "Resource not found"
echo $result->status(); // 404
```

## Available Result Types

- `Ok` (200)
- `Created` (201)
- `NoContent` (204)
- `BadRequest` (400)
- `Unauthorized` (401)
- `Forbidden` (403)
- `NotFound` (404)
- `Conflict` (409)
- `Gone` (410)
- `TooManyRequests` (429)
- `InternalServerError` (500)

## License

MIT License
