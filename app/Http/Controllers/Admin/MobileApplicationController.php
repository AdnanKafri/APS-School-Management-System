<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PublishMobileApplicationRequest;
use App\MobileApplication;
use App\Services\MobileApplicationReleaseService;
use App\Services\MobileApplicationDownloadService;
use Illuminate\Validation\ValidationException;
use Throwable;

class MobileApplicationController extends Controller
{
    public function index(MobileApplicationDownloadService $downloads)
    {
        MobileApplication::ensureFixedApplications();

        $applications = MobileApplication::with('currentRelease')
            ->whereIn('key', array_keys(config('mobile_applications.applications', [])))
            ->get()
            ->keyBy('key');

        $available = [];
        foreach ($applications as $key => $application) {
            $available[$key] = (bool) $downloads->current($key);
        }

        return view('admin.mobile_applications.index', compact('applications', 'available'));
    }

    public function publish(PublishMobileApplicationRequest $request, MobileApplicationReleaseService $service)
    {
        MobileApplication::ensureFixedApplications();

        try {
            $service->publish(
                $request->input('application_key'),
                $request->file('apk'),
                $request->input('version'),
                $request->input('release_notes'),
                $request->user()
            );
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            report($exception);
            return redirect()->route('admin.mobile-applications.index')
                ->withInput($request->only('application_key', 'version', 'release_notes'))
                ->withErrors(['apk' => __('mobile_apps.validation.store_failed')]);
        }

        return redirect()->route('admin.mobile-applications.index')
            ->with('success', __('mobile_apps.messages.published'));
    }
}
