<?php

declare(strict_types=1);

namespace IllumaLaw\HealthCheckMigration;

use Illuminate\Support\Facades\Artisan;
use Spatie\Health\Checks\Check;
use Spatie\Health\Checks\Result;

final class MigrationBacklogCheck extends Check
{
    public function run(): Result
    {
        Artisan::call('migrate:status', [
            '--pending' => true,
            '--no-ansi' => true,
        ]);

        $output = Artisan::output();
        $lines = preg_split("/\r\n|\n|\r/", $output) ?: [];
        $pendingLines = collect($lines)
            ->map(fn (string $line): string => trim($line))
            ->filter(fn (string $line): bool => str_ends_with($line, 'Pending'))
            ->values();

        $count = $pendingLines->count();

        $result = Result::make()
            ->meta([
                'pending_count' => $count,
                'sample' => $pendingLines->take(8)->all(),
            ])
            ->shortSummary("{$count} pending");

        if ($count > 0) {
            return $result->failed("There are {$count} pending database migration(s).");
        }

        return $result->ok('No pending migrations.');
    }
}
