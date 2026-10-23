# Healthcheck migration for Laravel

[![Tests](https://github.com/eloquage/healthcheck-migration/actions/workflows/run-tests.yml/badge.svg)](https://github.com/eloquage/healthcheck-migration/actions)
[![Packagist License](https://img.shields.io/badge/Licence-MIT-blue)](http://choosealicense.com/licenses/mit/)
[![Latest Stable Version](https://img.shields.io/packagist/v/illuma-law/healthcheck-migration?label=Version)](https://packagist.org/packages/illuma-law/healthcheck-migration)

A focused migration backlog health check for Spatie's [Laravel Health](https://spatie.be/docs/laravel-health/v1/introduction) package.

This package provides a simple, direct health check to verify that your application's database migrations are up to date.

## Features

- **Pending Migration Check:** Automatically detects if there are any pending database migrations that haven't been run yet.
- **Migration Count:** Reports the exact number of pending migrations in the health summary and meta data.
- **Detailed Meta:** Lists a sample of pending migration filenames for easier debugging via JSON endpoints.

## Installation

Require this package with composer:

```shell
composer require illuma-law/healthcheck-migration
```

## Usage & Integration

Register the check inside your application's health service provider (e.g. `AppServiceProvider` or a dedicated `HealthServiceProvider`), alongside your other Spatie Laravel Health checks:

### Basic Registration

```php
use IllumaLaw\HealthCheckMigration\MigrationBacklogCheck;
use Spatie\Health\Facades\Health;

Health::checks([
    MigrationBacklogCheck::new(),
]);
```

### Expected Result States

The check interacts with the Spatie Health dashboard and JSON endpoints using these states:

- **Ok:** All database migrations have been successfully applied.
- **Failed:** One or more database migrations are pending.

## Testing

Run the test suite:

```shell
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
