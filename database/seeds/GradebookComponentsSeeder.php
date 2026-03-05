<?php

use Illuminate\Database\Seeder;

class GradebookComponentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $year = \App\Year::where('current_year', '1')->first();
        if (!$year) return;

        // Fetch all Subjects
        $subjects = \App\Lesson::all();
        
        // Fetch existing Configs (if any)
        try {
            $configs = \App\GradebookConfig::where('year_id', $year->id)->get()->keyBy('lesson_id');
        } catch (\Exception $e) {
            $configs = collect();
        }

        foreach ($subjects as $subject) {
            // Check if components already exist
            $exists = \App\GradebookComponent::where('lesson_id', $subject->id)
                                             ->where('year_id', $year->id)
                                             ->exists();
            if ($exists) continue;

            // Get defaults from old config or use hardcoded defaults
            $conf = $configs->get($subject->id);
            $oralMax = $conf ? $conf->oral_max : 0;
            $hwMax = $conf ? $conf->homework_max : 0;
            $examMax = $conf ? $conf->exam_max : 0;

            // 1. Oral Component
            \App\GradebookComponent::create([
                'lesson_id' => $subject->id,
                'year_id' => $year->id,
                'name' => 'المشاركة (Oral)',
                'max_mark' => $oralMax,
                'weight' => 100,
                'sort_order' => 1,
                'data_source' => 'LEGACY_ORAL'
            ]);

            // 2. Homework Component
            \App\GradebookComponent::create([
                'lesson_id' => $subject->id,
                'year_id' => $year->id,
                'name' => 'الوظائف (Homework)',
                'max_mark' => $hwMax,
                'weight' => 100,
                'sort_order' => 2,
                'data_source' => 'LEGACY_HOMEWORK'
            ]);

            // 3. Exam Component
            \App\GradebookComponent::create([
                'lesson_id' => $subject->id,
                'year_id' => $year->id,
                'name' => 'الامتحان (Exam)',
                'max_mark' => $examMax,
                'weight' => 100,
                'sort_order' => 3,
                'data_source' => 'LEGACY_EXAM'
            ]);
        }
    }
}
