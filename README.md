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

### Informational Responses (1xx)
- `Continue` (100)
- `SwitchingProtocols` (101)
- `Processing` (102)
- `EarlyHints` (103)

### Success Responses (2xx)
- `Ok` (200)
- `Created` (201)
- `Accepted` (202)
- `NonAuthoritativeInformation` (203)
- `NoContent` (204)
- `ResetContent` (205)
- `PartialContent` (206)
- `MultiStatus` (207)
- `AlreadyReported` (208)
- `ImUsed` (226)

### Redirection Responses (3xx)
- `MultipleChoices` (300)
- `MovedPermanently` (301)
- `Found` (302)
- `SeeOther` (303)
- `NotModified` (304)
- `UseProxy` (305)
- `TemporaryRedirect` (307)
- `PermanentRedirect` (308)

### Client Error Responses (4xx)
- `BadRequest` (400)
- `Unauthorized` (401)
- `PaymentRequired` (402)
- `Forbidden` (403)
- `NotFound` (404)
- `MethodNotAllowed` (405)
- `NotAcceptable` (406)
- `ProxyAuthenticationRequired` (407)
- `RequestTimeout` (408)
- `Conflict` (409)
- `Gone` (410)
- `LengthRequired` (411)
- `PreconditionFailed` (412)
- `PayloadTooLarge` (413)
- `UriTooLong` (414)
- `UnsupportedMediaType` (415)
- `RangeNotSatisfiable` (416)
- `ExpectationFailed` (417)
- `ImATeapot` (418)
- `MisdirectedRequest` (421)
- `UnprocessableEntity` (422)
- `Locked` (423)
- `FailedDependency` (424)
- `TooEarly` (425)
- `UpgradeRequired` (426)
- `PreconditionRequired` (428)
- `TooManyRequests` (429)
- `RequestHeaderFieldsTooLarge` (431)
- `UnavailableForLegalReasons` (451)

### Server Error Responses (5xx)
- `InternalServerError` (500)
- `NotImplemented` (501)
- `BadGateway` (502)
- `ServiceUnavailable` (503)
- `GatewayTimeout` (504)
- `HttpVersionNotSupported` (505)
- `VariantAlsoNegotiates` (506)
- `InsufficientStorage` (507)
- `LoopDetected` (508)
- `NotExtended` (510)
- `NetworkAuthenticationRequired` (511)

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

- **Pest PHP**: Modern Testing Framework
  ```bash
  composer test           # Run tests
  composer test:coverage  # Run tests with coverage report
  ```

Custom expectations are available for Result objects:
```php
expect($result)
    ->toBeSuccessResult()
    ->and($result->status())->toBe(200);

expect($result)
    ->toBeErrorResult()
    ->and($result->status())->toBe(404);
```

## License

MIT License
