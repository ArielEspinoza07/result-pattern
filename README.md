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
composer require arielespinoza07/result-pattern
```

## Usage

```php
use ArielEspinoza07\ResultPattern\Ok;
use ArielEspinoza07\ResultPattern\NotFound;

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

### Success Responses (2xx)
- `Ok` (200)
- `Created` (201)
- `Accepted` (202)
- `NoContent` (204)

### Client Error Responses (4xx)
- `BadRequest` (400)
- `Unauthorized` (401)
- `Forbidden` (403)
- `NotFound` (404)
- `MethodNotAllowed` (405)
- `Conflict` (409)
- `Gone` (410)
- `UnprocessableEntity` (422)
- `TooManyRequests` (429)

### Server Error Responses (5xx)
- `InternalServerError` (500)
- `ServiceUnavailable` (503)

## Development

This package includes several development tools to ensure code quality and maintainability:

### Code Quality Tools

- **Rector**: PHP code modernizer and refactoring tool
  ```bash
  composer rector:check  # Check for possible changes
  composer rector:fix   # Apply changes
  ```

- **Laravel Pint**: PHP code style fixer following PSR-12
  ```bash
  composer pint        # Fix code style
  composer pint:test   # Check code style
  ```

- **PHPStan**: Static analysis tool
  ```bash
  composer analyse     # Run static analysis
  ```

### Testing

- **PHPUnit**: Unit testing framework
  ```bash
  composer test        # Run tests
  ```

- **Peck PHP**: Additional testing utilities

## License

MIT License
