<?php

namespace App\Http\Controllers;

use App\Services\RegistrationWizardService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistrationWizardController extends Controller
{
    /** @var RegistrationWizardService */
    protected $wizard;

    public function __construct(RegistrationWizardService $wizard)
    {
        $this->wizard = $wizard;
    }

    public function saveStep1Terms(Request $request)
    {
        $data = $request->validate([
            'draft_token' => 'nullable|string|max:100',
            'accepted_terms' => 'required|boolean',
        ]);

        if (!((bool) $data['accepted_terms'])) {
            return response()->json([
                'success' => false,
                'message' => __('wizard.errors.terms_required'),
            ], 422);
        }

        $draft = $this->wizard->saveStep1Terms($data['draft_token'] ?? null);

        return response()->json([
            'success' => true,
            'draft_token' => $this->wizard->activeToken(),
            'accepted_terms' => true,
            'next_step' => 2,
            'current_step' => (int) ($draft['current_step'] ?? 2),
        ]);
    }

    public function saveStep2Form(Request $request)
    {
        $data = $request->validate([
            'draft_token' => 'nullable|string|max:100',
            'form_data' => 'required|array',
            'form_data.first_name' => 'required|string|max:255',
            'form_data.last_name' => 'required|string|max:255',
            'form_data.father_name' => 'required|string|max:255',
            'form_data.mather_name' => 'required|string|max:255',
            'form_data.date' => 'required|date',
            'form_data.class1' => 'required|integer|exists:classes,id',
            'form_data.gender' => 'nullable|in:0,1',
            'form_data.religion' => 'nullable|in:0,1',
            'form_data.country' => 'required|string|max:255',
            'form_data.email' => 'nullable|email|max:255',
            'form_data.phone' => 'required|string|max:255',
            'form_data.father_phone' => 'nullable|string|max:255',
            'form_data.mather_phone' => 'nullable|string|max:255',
            'form_data.father_job' => 'nullable|string|max:255',
            'form_data.mather_job' => 'nullable|string|max:255',
            'form_data.guardian_name' => 'nullable|string|max:255',
            'form_data.guardian_relation' => 'nullable|string|max:255',
            'form_data.guardian_phone' => 'nullable|string|max:255',
            'form_data.permanent_address' => 'nullable|string|max:2000',
            'form_data.current_address' => 'nullable|string|max:2000',
            'form_data.medical_notes' => 'nullable|string|max:2000',
            'form_data.chronic_diseases' => 'nullable|string|max:2000',
            'form_data.allergies' => 'nullable|string|max:2000',
            'form_data.fever_medicine_permission' => 'nullable|boolean',
            'form_data.custody_notes' => 'nullable|string|max:2000',
            'form_data.other_phone' => 'nullable|string|max:255',
            'fourth_image' => 'nullable|file|max:4096',
            'passbord' => 'nullable|file|max:4096',
            'personal_image' => 'nullable|file|max:4096',
            'certification' => 'nullable|file|max:4096',
            'mather_page' => 'nullable|file|max:4096',
            'father_page' => 'nullable|file|max:4096',
        ]);

        $formData = $data['form_data'];
        $draftToken = trim((string) ($data['draft_token'] ?? ''));
        $existingDraft = $this->wizard->getDraft($draftToken);

        $requiredFiles = ['fourth_image', 'personal_image', 'certification', 'mather_page', 'father_page'];
        $missingFiles = [];

        foreach ($requiredFiles as $fileField) {
            $hasUploadedFile = $request->hasFile($fileField);
            $hasExistingFile = !empty($existingDraft['uploaded_files'][$fileField]['path'] ?? null);

            if (!$hasUploadedFile && !$hasExistingFile) {
                $missingFiles[$fileField] = __('wizard.errors.required_file');
            }
        }

        if (!empty($missingFiles)) {
            throw ValidationException::withMessages($missingFiles);
        }

        $uploadedFiles = [];
        foreach (['fourth_image', 'passbord', 'personal_image', 'certification', 'mather_page', 'father_page'] as $fileField) {
            if ($request->hasFile($fileField)) {
                $uploadedFiles[$fileField] = $request->file($fileField);
            }
        }

        $draft = $this->wizard->saveStep2Form($draftToken ?: null, $formData, $uploadedFiles);

        return response()->json([
            'success' => true,
            'draft_token' => $this->wizard->activeToken(),
            'current_step' => (int) ($draft['current_step'] ?? 3),
            'status' => $draft['status'] ?? null,
            'admission_status' => $draft['admission_status'] ?? null,
        ]);
    }

    public function storeTempFile(Request $request)
    {
        $data = $request->validate([
            'draft_token' => 'nullable|string|max:100',
            'field' => 'required|in:fourth_image,passbord,personal_image,certification,mather_page,father_page',
            'file' => 'required|file|max:4096',
        ]);

        $draftToken = trim((string) ($data['draft_token'] ?? ''));
        $temp = $this->wizard->saveWizardTempFile($request->file('file'), $data['field'], $draftToken ?: null);

        return response()->json([
            'success' => true,
            'draft_token' => $this->wizard->activeToken(),
            'field' => $data['field'],
            'temp_file' => $temp,
        ]);
    }

    public function saveStep3Transport(Request $request)
    {
        $data = $request->validate([
            'draft_token' => 'required|string|max:100',
            'wants_transport' => 'required|boolean',
            'accepted_transport_terms' => 'nullable|boolean',
        ]);

        $registration = $this->wizard->saveStep3Transport(
            $data['draft_token'],
            (bool) $data['wants_transport'],
            (bool) ($data['accepted_transport_terms'] ?? false)
        );

        return response()->json([
            'success' => true,
            'draft_token' => $this->wizard->activeToken(),
            'current_step' => (int) ($registration['current_step'] ?? 4),
            'status' => $registration['status'] ?? null,
            'admission_status' => $registration['admission_status'] ?? null,
        ]);
    }

    public function preparePaymentSummary(Request $request)
    {
        $data = $request->validate([
            'draft_token' => 'required|string|max:100',
        ]);

        $registration = $this->wizard->preparePaymentSummary($data['draft_token']);

        return response()->json([
            'success' => true,
            'draft_token' => $this->wizard->activeToken(),
            'current_step' => (int) ($registration['current_step'] ?? 5),
            'status' => $registration['status'] ?? null,
            'admission_status' => $registration['admission_status'] ?? null,
            'fees' => [
                'registration_fee' => $registration['fees']['registration_fee'] ?? 0,
                'services_fee' => $registration['fees']['services_fee'] ?? 0,
                'transport_fee' => $registration['fees']['transport_fee'] ?? 0,
                'total_amount' => $registration['fees']['total_amount'] ?? 0,
            ],
            'payment' => $registration['payment'] ?? [],
        ]);
    }

    public function finalSubmit(Request $request)
    {
        $data = $request->validate([
            'draft_token' => 'required|string|max:100',
            'payment_method' => 'nullable|in:manual,shamcash,0,1',
            'payment_receipt' => 'required|file|max:6144',
        ]);

        $paymentMethod = $data['payment_method'] ?? 'manual';

        $registration = $this->wizard->submitRegistration(
            $data['draft_token'],
            $paymentMethod,
            $request->file('payment_receipt')
        );

        $request->session()->flash('registration_success', [
            'title' => __('wizard.success.final_submit'),
            'hint' => __('wizard.success.final_submit_hint'),
        ]);

        return response()->json([
            'success' => true,
            'registration_id' => $registration->id,
            'status' => $registration->status,
            'admission_status' => $registration->admission_status,
            'payment_status' => $registration->payment_status,
            'message' => __('wizard.success.final_submit'),
        ]);
    }

}

