<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GradebookAggregationService;
use App\Room;

class AggregateGradebook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gradebook:aggregate {--room_id=} {--student_id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aggregates teacher marks (quizzes, homeworks) into the central Gradebook';

    protected $service;

    public function __construct(GradebookAggregationService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $roomId = $this->option('room_id');
        $studentId = $this->option('student_id');

        $this->info('Starting Gradebook Aggregation...');

        if ($roomId) {
            $this->info("Aggregating for Room ID: $roomId");
            $result = $this->service->aggregateRoom($roomId);
            if ($result['status'] === 'error') {
                $this->error($result['message']);
            } else {
                $this->info($result['message']);
            }
        } 
        elseif ($studentId) {
             $this->info("Aggregating for Student ID: $studentId");
             // Fetch current year ID manually for single student call from command
             $year = \App\Year::where('current_year', '1')->first();
             if ($year) {
                $this->service->aggregateStudent($studentId, $year->id);
                $this->info("Aggregation process finished for student $studentId.");
                $this->comment("Check students_marks table for updates.");
             } else {
                 $this->error("Current year not found.");
             }
        } 
        else {
            $this->error('Please provide --room_id or --student_id');
            return 1;
        }

        $this->info('Aggregation completed successfully.');
        return 0;
    }
}
