<?php

declare(strict_types=1);

use IllumaLaw\HealthCheckMigration\MigrationBacklogCheck;
use Illuminate\Contracts\Console\Kernel;
use Spatie\Health\Enums\Status;

it('succeeds when there are no pending migrations', function () {
    $mock = Mockery::mock(Kernel::class);
    $mock->shouldReceive('call')->once()->andReturn(0);
    $mock->shouldReceive('output')->once()->andReturn("No pending migrations found.\n");
    assert($this->app !== null);
    assert($this->app !== null);
    $this->app->instance(Kernel::class, $mock);

    $result = MigrationBacklogCheck::new()->run();

    expect($result->status)->toEqual(Status::ok())
        ->and($result->shortSummary)->toBe('0 pending');
});

it('fails when there are pending migrations', function () {
    $mock = Mockery::mock(Kernel::class);
    $mock->shouldReceive('call')->once()->andReturn(0);
    $mock->shouldReceive('output')->once()->andReturn("2023_01_01_000000_create_users_table ........................... Pending\n2023_01_01_000001_create_posts_table ........................... Pending\n");
    assert($this->app !== null);
    assert($this->app !== null);
    $this->app->instance(Kernel::class, $mock);

    $result = MigrationBacklogCheck::new()->run();

    expect($result->status)->toEqual(Status::failed())
        ->and($result->shortSummary)->toBe('2 pending')
        ->and($result->meta['pending_count'])->toBe(2);
});
