<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendLessonContentNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 3;
    private $ids;

    public function __construct(array $ids) { $this->ids = $ids; }

    public function handle()
    {
        foreach (\App\Notification::whereIn('id', $this->ids)->get() as $notice) {
            $devices = \App\Studentfcmtoken::where('s_fk', $notice->student_id)->pluck('s_fcm_token')->all();
            if ($devices) app(\App\Http\Controllers\TeacherController_New::class)->send_notification(
                $notice->title, $notice->body, $notice->id, $notice->type, $notice->room_id, $notice->lesson_id, $notice->lecture_id, $devices);
        }
    }
}
