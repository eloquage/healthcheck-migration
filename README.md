# Healthcheck Migration for Laravel

![Healthcheck Migration banner](art/banner.png)

[![Tests](https://github.com/eloquage/healthcheck-migration/actions/workflows/run-tests.yml/badge.svg)](https://github.com/eloquage/healthcheck-migration/actions/workflows/run-tests.yml)
[![Latest Stable Version](https://img.shields.io/packagist/v/illuma-law/healthcheck-migration?label=Version)](https://packagist.org/packages/illuma-law/healthcheck-migration)
[![License](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE.md)

A [Spatie Laravel Health](https://spatie.be/docs/laravel-health) check that lists pending database migrations and reports whether Artisan could read migration status.

## Requirements

- PHP 8.3 or later
- Laravel 12 or 13
- `spatie/laravel-health` 1.39 or later

## Installation

```bash
composer require illuma-law/healthcheck-migration
```

Laravel discovers the service provider automatically. To customize whether pending migrations warn or fail, publish the configuration:

```bash
php artisan vendor:publish --tag=healthcheck-migration-config
```

By default, pending migrations produce a warning. Set `HEALTH_MIGRATION_REQUIRED=true` to make a pending backlog fail the check. If Laravel cannot read migration status, the check always fails.

## Usage

Register the check in your health service provider:

```php
use IllumaLaw\HealthCheckMigration\MigrationBacklogCheck;
use Spatie\Health\Facades\Health;

Health::checks([
    MigrationBacklogCheck::new(),
]);
```

The result includes `pending_count` and up to eight pending migration rows in its metadata. No pending migrations returns **OK**, pending migrations return **Warning** by default or **Failed** when required, and an Artisan/database error returns **Failed**.

## Testing

```bash
composer test
composer analyse
vendor/bin/pint --test
```

## License

MIT. See [LICENSE.md](LICENSE.md).
