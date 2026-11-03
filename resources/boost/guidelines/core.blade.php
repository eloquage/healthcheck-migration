# eloquage/healthcheck-migration

Checks if the `vector` extension (migration) is enabled and active in PostgreSQL.

## Usage

```php
use IllumaLaw\HealthCheckMigration\MigrationExtensionCheck;
use Spatie\Health\Facades\Health;

Health::checks([
    MigrationExtensionCheck::new()
        ->required(true), // If true, FAIL if missing. If false, WARNING.
]);
```

## Configuration

Publish config: `php artisan vendor:publish --tag="healthcheck-migration-config"`

Options in `config/healthcheck-migration.php`:
- `required`: (bool) Global default for strictness.
