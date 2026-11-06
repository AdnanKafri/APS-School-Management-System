<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanupLessonContent extends Command
{
    protected $signature = 'lesson-content:cleanup {--execute : Purge verified unowned files and pending removals}';
    protected $description = 'Inspect private lesson cleanup journals (dry run unless --execute is supplied)';

    public function handle()
    {
        if (!app(\App\Services\LessonContentFeature::class)->enabled()) { $this->error('Lesson content is not activated.'); return 1; }
        $this->line(json_encode(app(\App\Services\LessonContentRecovery::class)->run((bool)$this->option('execute'))));
        return 0;
    }
}
