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

---

A modern and simple implementation of the Result pattern for handling operation outcomes or HTTP responses.

> **Requires [PHP 8.3+](https://php.net/releases/) **

---
## Features

- 🛡️ Type-safe result handling with strict type hints
- 🌐 Complete HTTP response status codes support (1xx to 5xx)
- 🔒 Immutable objects using PHP 8.3+ readonly classes
- 🎯 SOLID principles adherence
- 🧩 Composable and extensible design
- 📝 Comprehensive test suite with Pest PHP

---

## Project Structure

```
src/
├── Enums/
│   └── HttpResponseStatusCode.php
├── Failure.php
├── Success.php
└── Result.php
```

---

## Installation

```bash
composer require arielespinoza07/result-pattern
```

---

## Documentation

The following documentation files provide examples and usage patterns for the Result pattern:

- [Basic Success and Failure Examples](docs/basic-examples.md) - Creating and using Success and Failure objects
- [Try Method Examples](docs/try-method-examples.md) - Using the `try` method to handle operations that might throw exceptions
- [onSuccess and onFailure Examples](docs/on-success-failure-examples.md) - Using callbacks for Success and Failure cases
- [Map Method Examples](docs/map-method-examples.md) - Transforming values inside Success results
- [FlatMap Method Examples](docs/flat-map-method-examples.md) - Transforming Success results into new Result objects
- [Fold Method Examples](docs/fold-method-examples.md) - Handling both Success and Failure cases with a single return value
- [Error Handling Examples](docs/error-handling-examples.md) - Proper error handling techniques and best practices

---

## Available Response Codes

- Informational Responses (1xx)
- Success Responses (2xx)
- Redirection Responses (3xx)
- Client Error Responses (4xx)
- Server Error Responses (5xx)

---

## Development

### Requirements

- PHP 8.3+
- Composer 2.0+

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

---

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

---

## Continuous Integration

GitHub Actions automatically run the following checks on push and pull requests:

- Static analysis with PHPStan (level max)
- Unit tests with Pest PHP
- Code style with Laravel Pint
- Type coverage check
- Typo check with Peck

---

## Testing
This package uses Pest PHP for testing. To run the tests:

```bash
composer test
```

To generate a coverage report:
```bash
composer test:coverage
```

The coverage report will be available in the `coverage` directory.

---

## Development Tools
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
---

## License

[MIT License](LICENSE)
