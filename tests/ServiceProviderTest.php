<?php

declare(strict_types=1);

use IllumaLaw\HealthCheckMigration\HealthcheckMigrationServiceProvider;
use Illuminate\Support\ServiceProvider;

it('registers the config publish path under the correct tag', function () {
    $provider = app()->getProvider(IllumaLaw\HealthCheckMigration\HealthcheckMigrationServiceProvider::class);
    $source = dirname((new \ReflectionClass($provider))->getFileName()).'/../config/healthcheck-migration.php';

    expect(ServiceProvider::pathsToPublish($provider::class, 'healthcheck-migration-config'))
        ->toBe([$source => config_path('healthcheck-migration.php')]);
});

it('loads config with the correct default', function () {
    expect(config('healthcheck-migration.required'))->toBeFalse();
});
