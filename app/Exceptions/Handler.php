<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        $publicComplaintSubmission = $request->isMethod('POST') && $request->routeIs(
            'website.complaints.store', 'website.staff_feedback.store.ar', 'website.staff_feedback.store.en'
        );
        if ($publicComplaintSubmission) {
            if (in_array($request->segment(1), ['ar', 'en'], true)) {
                app()->setLocale($request->segment(1));
            }
            if ($exception instanceof \Illuminate\Validation\ValidationException) {
                $exception->redirectTo($request->url());
            }
            if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
                return redirect()->to($request->url())
                    ->withInput($request->except(array_merge($this->dontFlash, ['_token'])))
                    ->withErrors(['complaint' => __('complaints.validation.session_expired')]);
            }
        }
        if ($exception instanceof \Illuminate\Session\TokenMismatchException ) {
            if ($request->is('complaint-portal/*')) {
                return redirect()->route('complaint-portal.login')->withErrors(['session' => __('complaint_portal.session_expired')]);
            }
            return redirect()->route('login');
        }
        return parent::render($request, $exception);
    }
}
