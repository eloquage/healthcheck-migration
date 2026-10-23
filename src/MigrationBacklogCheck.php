<?php

declare(strict_types=1);

namespace IllumaLaw\HealthCheckMigration;

use Illuminate\Support\Facades\Artisan;
use Spatie\Health\Checks\Check;
use Spatie\Health\Checks\Result;
use Throwable;

final class MigrationBacklogCheck extends Check
{
    public function run(): Result
    {
        try {
            $exitCode = Artisan::call('migrate:status', [
                '--pending' => true,
                '--no-ansi' => true,
            ]);

            $output = Artisan::output();
        } catch (Throwable $exception) {
            return Result::make()
                ->failed(trans('healthcheck-migration::messages.query_failed', ['message' => $exception->getMessage()]))
                ->shortSummary('Check failed');
        }

        $lines = preg_split("/\r\n|\n|\r/", $output) ?: [];
        $pendingLines = collect($lines)
            ->map(fn (string $line): string => trim($line))
            ->filter(fn (string $line): bool => str_ends_with($line, 'Pending'))
            ->values();

        $count = $pendingLines->count();

        if ($count === 0 && $exitCode !== 0) {
            return Result::make()
                ->failed(trans('healthcheck-migration::messages.query_failed', ['message' => "Artisan exited with code {$exitCode}."]))
                ->shortSummary('Check failed');
        }

        $result = Result::make()
            ->meta([
                'pending_count' => $count,
                'sample' => $pendingLines->take(8)->all(),
            ])
            ->shortSummary("{$count} pending");

        if ($count > 0) {
            $message = trans('healthcheck-migration::messages.pending', ['count' => $count]);

            if (filter_var(config('healthcheck-migration.required', false), FILTER_VALIDATE_BOOLEAN)) {
                return $result->failed($message);
            }

            return $result->warning($message);
        }

        return $result->ok('No pending migrations.');
    }
}
