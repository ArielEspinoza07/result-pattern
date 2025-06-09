# Result Pattern

<p>
  <a href="https://github.com/ArielEspinoza07/result-pattern/actions">
    <img src="https://github.com/ArielEspinoza07/result-pattern/actions/workflows/tests.yml/badge.svg"  alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/arielespinoza07/result-pattern">
    <img src="https://img.shields.io/packagist/dt/arielespinoza07/result-pattern.svg?style=flat-square" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/arielespinoza07/result-pattern">
    <img src="https://img.shields.io/packagist/v/arielespinoza07/result-pattern.svg?style=flat-square" alt="Latest Stable Version">
  </a>
  <a href="https://github.com/ArielEspinoza07/result-pattern/blob/main/LICENSE">
    <img src="https://img.shields.io/badge/license-MIT-green.svg" alt="License">
  </a>
</p>

A modern and simple PHP 8.3+ implementation of the Result pattern for handling operation outcomes and HTTP responses.

## Features

- 🛡️ Type-safe result handling with strict type hints
- 🌐 Complete HTTP response status codes support (1xx to 5xx)
- 🔒 Immutable objects using PHP 8.3+ readonly classes
- 🎯 SOLID principles adherence
- 🧩 Composable and extensible design
- 📝 Comprehensive test suite with Pest PHP

## Project Structure

```
src/
├── Contracts/
│   ├── CreateFromMessageAndDataContract.php
│   └── CreateFromMessageContract.php
├── Enums/
│   └── HttpResponseStatusCode.php
├── Traits/
│   ├── CreateFromMessage.php
│   └── CreateFromMessageAndData.php
├── Failed.php
├── Ok.php
└── Result.php
```

## Installation

```bash
composer require arielespinoza07/result-pattern
```

## Usage

```php
use ArielEspinoza07\ResultPattern\Ok;
use ArielEspinoza07\ResultPattern\Failed;
use ArielEspinoza07\ResultPattern\Enums\HttpResponseStatusCode;

// Success case
$result = Ok::fromMessageAndData(
    message: "Operation successful",
    status: HttpResponseStatusCode::OK,
    data: ["id" => 1]
);

if ($result->isSuccess()) {
    $data = $result->data(); // array<string, mixed>
}

// Error case
$result = Failed::fromMessage(
    message: "Resource not found",
    status: HttpResponseStatusCode::NotFound
);

echo $result->message(); // "Resource not found"
echo $result->status(); // 404

// Convert to array
$array = $result->toArray();
/*
[
    'success' => false,
    'message' => 'Resource not found',
    'status' => 404,
    'data' => []
]
*/
```

## Available Response Codes

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

### Requirements

- PHP 8.3+
- Composer 2.0+

### Quality Tools

This package uses several tools to ensure code quality:

```bash
# Run all checks
composer test

# Run specific checks
composer test:lint     # Check code style
composer test:types    # Run static analysis
composer test:unit     # Run unit tests
composer test:coverage # Check test coverage
```

### Continuous Integration

GitHub Actions automatically run the following checks on push and pull requests:

- Static analysis with PHPStan (level max)
- Unit tests with Pest PHP
- Code style with Laravel Pint
- Type coverage check
- Typo check with Peck

## Development

### Requirements
- PHP 8.3 or higher
- Composer 2.0 or higher

### Installation
```bash
composer require arielespinoza07/result-pattern
```

### Development Installation
```bash
git https://github.com/ArielEspinoza07/result-pattern.git
cd result-pattern
composer install
```

### Testing
This package uses Pest PHP for testing. To run the tests:

```bash
composer test
```

To generate a coverage report:
```bash
composer test:coverage
```

The coverage report will be available in the `coverage` directory.

### Development Tools
This package uses several development tools: to ensure code quality and maintainability:

### Code Quality Tools

- **Pest PHP**: Modern Testing Framework with custom expectations
  ```bash
  composer test           # Run tests
  composer test:coverage  # Run tests with coverage report
  ```

- **Laravel Pint**: PSR-12 Code Style Fixer
  ```bash
  composer pint      # Fix code style
  composer pint:test # Check code style
  ```

- **PHPStan**: Static Analysis (Level 9)
  ```bash
  composer analyse   # Run static analysis
  ```

- **Rector**: PHP 8.3 Compatibility and Code Quality
  ```bash
  composer rector    # Run code quality checks
  ```

## License

[MIT License](LICENSE)
