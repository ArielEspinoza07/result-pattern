# Contributing

Thank you for considering a contribution to `result-pattern`!

## Prerequisites

- **PHP** 8.3 or higher
- **Composer** (latest stable)

## Setup

```bash
git clone https://github.com/arielespinoza07/result-pattern.git
cd result-pattern
composer install
```

## Available scripts

| Command                   | Description                                    |
| ------------------------- | ---------------------------------------------- |
| `composer lint`           | Check code style with Laravel Pint             |
| `composer lint:fix`       | Auto-fix code style issues                     |
| `composer analyse`        | Run PHPStan static analysis (level max)        |
| `composer test`           | Run the Pest test suite                        |
| `composer test:coverage`  | Run tests with code-coverage report            |
| `composer check`          | Run lint, analyse, and test in sequence        |

Run `composer check` before opening a pull request to ensure all checks pass locally.

## Code style

Code style is enforced by **Laravel Pint**, configured in `pint.json`.
Run `composer lint:fix` to apply automatic fixes.

## Static analysis

The project uses **PHPStan at level max**, configured in `phpstan.neon`.
Both `src/` and `tests/` are analysed.

## Pull request process

1. Branch off `main`:
   ```bash
   git checkout -b feat/your-feature
   ```
2. Make your changes with **one atomic commit per logical change**.
3. Run `composer check` and fix any reported issues.
4. Open a pull request against `main` with a clear description of what changes
   and why.

## Changelog

Do **not** edit `CHANGELOG.md` manually. It is updated as part of the release
PR by the maintainers.
