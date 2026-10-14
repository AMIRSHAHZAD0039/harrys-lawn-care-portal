<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RouteScheduleService;

class GenerateWeeklyRoutes extends Command
{
    protected $signature = 'routes:generate-weekly {date? : Service date Y-m-d; defaults to today}';

    protected $description = 'Generate optimized route schedules for all active teams for the given week';

    public function handle(RouteScheduleService $service): int
    {
        $summary = $service->generateForWeek($this->argument('date'));

        foreach ($summary as $team => $data) {

            $this->line("{$team}: created {$data['created']} / eligible {$data['eligible']}");

            foreach ($data['skipped'] as $reason) {
                $this->line("   skipped — {$reason}");
            }
        }

        $this->info('Route generation complete.');

        return self::SUCCESS;
    }
}