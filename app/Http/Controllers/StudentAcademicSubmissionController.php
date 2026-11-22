<?php

namespace App\Http\Controllers;

use App\Services\StudentAcademicHistory;

class StudentAcademicSubmissionController extends Controller
{
    public function download($placement_id, $kind, $submission_id)
    {
        $file = app(StudentAcademicHistory::class)->submissionFile($placement_id, $kind, $submission_id);
        $response = response()->download($file, basename($file), [
            'Cache-Control' => 'private, no-store, max-age=0',
            'X-Content-Type-Options' => 'nosniff',
            'Content-Security-Policy' => "sandbox; default-src 'none'",
        ]);
        $response->setPrivate();
        return $response;
    }
}
